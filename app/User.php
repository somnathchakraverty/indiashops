<?php namespace indiashopps;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;
use indiashopps\Models\Cashback\UserCashback;
use indiashopps\Models\Cashback\UserWithdrawal;
use indiashopps\Models\Company;
use indiashopps\Models\UserMapping;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, Notifiable;

	const CREATED_AT = 'join_date';
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'and_user';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password', 'gender', 'interests', 'extension_id', 'username', 'referrer_id' ];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password'];

	public function cashback()
	{
		return $this->hasMany(UserCashback::class, 'user_id', 'id');
	}
	public function paid()
	{
		return $this->hasMany(UserWithdrawal::class, 'user_id', 'id')->whereStatus('paid')->select([
			'user_id',
			'cashback_amount'
		]);
	}
	public function withdrawals()
	{
		return $this->hasMany(UserWithdrawal::class, 'user_id', 'id');
	}
	public static function getAvailableCashbackAmount()
	{
		$earnings = UserCashback::whereUserId(\Auth::user()->id)->whereIn('status', [
			UserCashback::STATUS_APPROVED,
		])->select(['status', \DB::raw('SUM(cashback_amount) as amount')])->groupBy('status')->first();
		if (!is_null($earnings)) {
			$available = $earnings->toArray()['amount'];
			$withdrawal = UserWithdrawal::whereIn('status', ['requested', 'processing'])
										->whereUserId(\Auth::user()->id)
										->first();
			if (!is_null($withdrawal)) {
				if ($available > $withdrawal->amount) {
					return $available - $withdrawal->amount;
				} else {
					return 0;
				}
			}
			return $earnings->toArray()['amount'];
		}
		return 0;
	}
	public function company()
	{
		return $this->belongsTo(Company::class, 'company_id', 'id');
	}
	public function mapping()
	{
		return $this->hasOne(UserMapping::class, 'user_id', 'id');
	}
	public function getPermissions()
	{
		if (!is_null($this->mapping) && !is_null($this->company)) {
			if ($permissions = json_decode($this->mapping->permissions)) {
				if (count($permissions) > 0) {
					return (array)$permissions;
				}
			}
			return [];
		}
		return array_diff(array_keys(UserMapping::PERMISSIONS), array_values(UserMapping::EXTENDED_PERMISSIONS));
	}
	public function isAdmin()
	{
		if (!is_null($this->mapping)) {
			if ($this->mapping->user_type == 'admin') {
				return true;
			} else {
				return false;
			}
		}
		return false;
	}
	public function needsPermission($permission)
	{
		if (is_null($this->company)) {
			foreach ($permission as $p) {
				if (in_array($p, UserMapping::EXTENDED_PERMISSIONS)) {
					return false;
				}
			}
			return true;
		} elseif ($this->isAdmin()) {
			return true;
		}
		return false;
	}
	/**
	 * @return \Illuminate\Database\Query\Builder|static
	 */
	public static function usersQuery()
	{
		$query = self::query();
		$users = $query->select(['and_user.*', 'user_mappings.permissions', 'user_mappings.user_type'])
					   ->leftJoin('user_mappings', 'and_user.id', '=', 'user_mappings.user_id')
					   ->where('and_user.id', "!=", auth()->user()->id)
					   ->where('user_type', 'user')
					   ->where('company_id', auth()->user()->company_id)
					   ->whereNotNull('user_mappings.id');
		return $users;
	}
	public static function getCashbackUserId()
	{
		if (auth()->check()) {
			$user = auth()->user();
			if (is_null($user->company)) {
				return $user->id;
			}
			$user = UserMapping::select(['user_mappings.user_id'])
							   ->leftJoin('and_user', 'and_user.id', '=', 'user_mappings.user_id')
							   ->whereUserType('admin')
							   ->whereCompanyId($user->company_id)
							   ->first();
			return $user->user_id;
		}
		if( request()->cookie('ext_user_id') )
		{

		}
		return 0;
	}
	public function userConditionChecks()
	{
		if (!is_null($this->company)) {
			session()->put('corporate_user', true);
		}
		if ($this->isAdmin()) {
			$query = self::query();
			$users = $query->select('user_mappings.*')
						   ->leftJoin('user_mappings', 'user_mappings.user_id', '=', 'and_user.id')
						   ->where('company_id', $this->company_id)
						   ->where('user_type', 'user')
						   ->get();
			foreach ($users as $user) {
				$permissions = json_decode($user->permissions);
				if (in_array('purchase.approve', $permissions)) {
					$has_approver = true;
					break;
				}
			}
			if (isset($has_approver)) {
				session()->put("has_approver", true);
			} else {
				session()->forget('has_approver');
			}
		}
	}

}
