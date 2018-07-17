$(document).ready(function() {
    $(".hideLogIn").click(function()
    {
        console.log("login is ready.");
        $("#login-form").hide();
        $("#register-form").show();
    });

    $(".hideRegister").click(function()
    {
        console.log("register is ready.");
        $("#login-form").show();
        $("#register-form").hide();
    });
});
