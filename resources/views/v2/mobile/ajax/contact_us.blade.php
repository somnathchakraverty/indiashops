<div class="breadcrumb-bg">
    <div class="container">
        {!! Breadcrumbs::render("contact") !!}
    </div>
</div>
<!--PART-1-->
<div class="signupbg">
    <div class="container">
        <div class="feedback">Feedback & Suggestions !!</div>
        <form method="post" id="contactForm">
            <div class="col-md-12 form-line">
                <div class="errors alert alert-danger" style="display: none"></div>
                <div class="success alert alert-success" style="display: none"></div>
            </div>
            <div class="col-md-6 form-line">
                <div class="form-group">
                    <input type="text" class="form-control" id="" placeholder="Enter Name" required name="name">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="exampleInputEmail" placeholder="Enter Email id"
                           required name="email">
                </div>
                <div class="form-group">
                    <input type="tel" class="form-control" id="telephone" placeholder="Enter mobile no." required
                           onkeyup="this.value=this.value.replace(/[!-/A-Za-z]/g,'');" maxlength="10" pattern=".{10,}"
                           name="mobile">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <textarea class="form-control contmessage" id="description"
                              placeholder="Enter Your Message" required name="message"></textarea>
                </div>
                <div>
                    <a type="button" class="btn btn-default submit sendmes" id="send_message">Send Message</a>
                    <img src="{{asset('assets/v2/images/loading.gif')}}" style="display:none" id="loadergif"/>
                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                    <input type="hidden" name="page_section" value="contact" />
                    <input type="hidden" name="type" value="mobile_pages" />
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#send_message").click(function () {
            var form = document.getElementById('contactForm');
            $('.errors').html('');

            error = validateForm( form );

            if( error.length == 0 )
            {
                $('.errors').html('').hide();
                $('#loadergif').show();

                sendFormRequest(form,'post',function(){
                    $('.success').html("Thank you for contacting us..!").show();
                    $('#loadergif').hide();
                });
            }
        });
    });
</script>