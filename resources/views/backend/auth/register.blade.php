<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Register - SB Admin</title>
    <link href="{{asset('assets/backend/css/style.css')}}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


</head>
<body class="bg-primary">

<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                            <div class="card-body">
                                <form id="main" method="POST">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input name="firstName" class="form-control" id="inputFirstName" type="text" placeholder="Enter your first name" />
                                                <label for="inputFirstName">First name</label>
                                                <div class="col-sm-5 firstNameMessages message" id="firstNameMessages"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="lastName" class="form-control" id="inputLastName" type="text" placeholder="Enter your last name" />
                                                <label for="inputLastName">Last name</label>
                                                <div class="col-sm-5 lastNameMessages message"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input name="email" class="form-control" id="inputEmail" type="email" placeholder="name@example.com" />
                                        <label for="inputEmail">Email address</label>
                                        <div class="col-sm-5 emailMessages message"></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input name="password" class="form-control" id="inputPassword" type="password" placeholder="Create a password" />
                                                <label for="inputPassword">Password</label>
                                                <div class="col-sm-5 passwordMessages message"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input name="confirmPassword" class="form-control" id="inputPasswordConfirm" type="password" placeholder="Confirm password" />
                                                <label for="inputPasswordConfirm">Confirm Password</label>
                                                <div class="col-sm-5 confirmPasswordMessages message"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 mb-0">
                                        <button class="btn btn-primary btn-block register">Create Account</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center py-3">
                                <div class="small"><a href="login.html">Have an account? Go to login</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
{{--    <div id="layoutAuthentication_footer">--}}
{{--        <footer class="py-4 bg-light mt-auto">--}}
{{--            <div class="container-fluid px-4">--}}
{{--                <div class="d-flex align-items-center justify-content-between small">--}}
{{--                    <div class="text-muted">Copyright &copy; Your Website 2022</div>--}}
{{--                    <div>--}}
{{--                        <a href="#">Privacy Policy</a>--}}
{{--                        &middot;--}}
{{--                        <a href="#">Terms &amp; Conditions</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </footer>--}}
{{--    </div>--}}
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="{{asset('assets/backend/js/scripts.js')}}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>

<script  type="text/javascript" >

    let constraints= {
        firstName:{
            presence:true,
            format:{
                pattern: "[a-z]+",
                message: "can only contain a-z "
            }
        },
        lastName:{
            presence:true,
            format:{
                pattern: "[a-z]+",
                message: "can only contain a-z"
            }
        },
        email:{
            presence:true,
            // format:{
            //     pattern: "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/",
            //     message: "is not valid !"
            // }
        },
        password:{
            presence:true,
            length:{
                minimum:6,
                message: "must be at least 6 characters !"
            },
            // format:{
            //     pattern: "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$",
            //     message: "is not valid!"
            // }
        },
        confirmPassword:{
            presence:true,
            equality:"password"
        }
    }

    let inputs = document.querySelectorAll("input");

    let form = document.querySelector("form#main");

    form.addEventListener('submit',function (ev)
    {
        ev.preventDefault()
        handleSubmit(form, inputs);
    })

    function handleSubmit(form, inputs)
    {
        let check = validate(form,constraints) ;

        if(!check)
        {
            showSuccess()
        } else
        {
            showErrors(form,check)
        }
    }

    function showErrors(form, errors) {
        // We loop through all the inputs and show the errors for that input
        _.each(form.querySelectorAll("input[name]"), function(input) {
            // Since the errors can be null if no errors were found we need to handle
            // that
            showErrorForInput(input, errors && errors[input.name]);
        });
    }

    for(let i =0;i<inputs.length;i++)
    {

      inputs[i].addEventListener("change",function (e){
          let errors = validate(form,constraints) || {};
          showErrorForInput(this,errors[this.name]);
      });
    }

    function showErrorForInput(input, errors)
    {

       let formFloating = closestParent(input.parentNode,"form-floating");
        let messages = formFloating.querySelector(".message");

        resetFormGroup(formFloating);
       if (errors)
       {
           formFloating.classList.add("has-error");
            addError(messages, errors);
       } else
       {
           formFloating.classList.add("has-success");
        }
    }

    function closestParent(child, className) {
        if (!child || child === document) {
            return null;
        }
        if (child.classList.contains(className)) {
            return child;
        } else {
            return closestParent(child.parentNode, className);
        }
    }

    function addError(messages, error) {
        let block = document.createElement("p");
        block.classList.add("help-block");
        block.classList.add("error");
        block.innerText = error;
        block.style.color = "red";
        messages.appendChild(block);
    }

    function resetFormGroup(formGroup) {
        // Remove the success and error classes
        formGroup.classList.remove("has-error");
        formGroup.classList.remove("has-success");
        // and remove any old messages
        _.each(formGroup.querySelectorAll(".help-block.error"), function(el) {
            el.parentNode.removeChild(el);
        });
    }

    function showSuccess() {
        // We made it \:D/
        alert("Success!");
    }

</script>

</body>
</html>
