 @extends('v1.layouts.master')
 @section('meta')
 <style type="text/css"> 
h1 {
  font: 400 40px/1.5 Helvetica, Verdana, sans-serif;
  margin: 0;
  padding: 0;
} 
ul {
  list-style-type: none;
  margin: 0; width:auto;
  padding: 0;
}
 
li {
  font: 200 20px/1.5 Helvetica, Verdana, sans-serif;
  border-bottom: 1px solid #ccc;
} 
li:last-child {
  border: none;
} 
li a {
  text-decoration: none;
  color: #000;
  display: block; 
  font-size: 14px; 
  -webkit-transition: font-size 0.3s ease, background-color 0.3s ease;
  -moz-transition: font-size 0.3s ease, background-color 0.3s ease;
  -o-transition: font-size 0.3s ease, background-color 0.3s ease;
  -ms-transition: font-size 0.3s ease, background-color 0.3s ease;
  transition: font-size 0.3s ease, background-color 0.3s ease;
}
li.list-group-item{border:none;}
 </style>
 @endsection
 @if(isset($description) && !empty($description))
   @section('description')
   <meta name="description" content="{{strip_tags( html_entity_decode( $description ) )}}" />
   @endsection
 @endif
 @section('content')
 <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">           
      {!! Breadcrumbs::render() !!}        
        <div class="row">
           <h1>List of {{ucwords($group)." ".ucwords($category)}}</h1>        
            @foreach($list as $l)
              @if($i%$break_point == 0)
                <div class="col-md-3 col-sm-3">                 
                  <ul class="list-group"> 
              @endif
                 <li class="list-group-item"><a href="{{url('list-of-'.create_slug($group).'-'.create_slug($category).'/'.create_slug($l->keyword))}}" target="_blank">{{ucwords(reverse_slug($l->keyword))}}</a></li>
              <?php $i++ ?>
              @if($i%$break_point == 0)
                  </ul>
                </div>
              @endif             
            @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
 </div>
@endsection