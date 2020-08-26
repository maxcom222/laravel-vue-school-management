<template>

    <div class="frame contact-buyer">

        <h3>Contact Admissions:</h3>

        <form>


            <div class="form-row">

                <div class="form-group col-12">

                    <label for="">Parent's Email</label>


                    <input type="email" class="form-control" ref="profile_email" placeholder="">

                    <!--  admission_email -->


                </div>

            </div>


            <div class="form-row">

                <div class="form-group col-md-12">

                    <label for="">Parent's Full Name</label>

                    <input type="text" class="form-control" ref="js_profile_name" placeholder="">

                </div>

            </div>

            <div class="form-row">

                <div class="form-group col-12">

                    <label for="">Child's Name</label>

                    <input type="email" class="form-control" ref="js_profile_child_name" placeholder="">

                </div>


            </div>


            <div class="form-row">

                <div class="form-group col-12">

                    <label for="">Message</label>

                    <textarea class="form-control" style="height:200px;" ref="js_profile_msg"></textarea>

                </div>

            </div>


        </form>

        <p class="alert alert-primary ">By clicking on 'Send', I agree to the Expats' School <a target="_blank" href="{{ asset('terms')  }}">Terms & Conditions</a> and <a  target="_blank" href="{{ asset('privacy')  }}">Privacy Policy</a></p>

        <p class="alert alert-success d-none js_status_mssg"></p>

        <a id="js_enquiry_2" href="" class="btn btn-sm btn-primary">Send</a>

    </div>


</template>

<script>

    export default {

        name: "SchooldetailComponent"

    }


</script>

<style scoped>

</style>