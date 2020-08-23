$(document).ready(function(){
    $("body").on("click", ".insert-in-cart", addToCart);
    $("#clear-cart").click(clearCart);
    $("#idRegister").click(sendData);
    $("#c_password").keyup(checkPasswordFields);
    $("#c_username").blur(checkForUsername);
    $("#c_email").blur(checkForEmail);
    $("#login_submit").click(checkLogin);
    $(".word-download").click(downloadWordFile);

});

function productsInCart(){
    return JSON.parse(localStorage.getItem("products"));
}
function clearCart() {
    localStorage.removeItem("products");
    window.location.reload();
}
function addToCart(e){
    e.preventDefault();
    let id = $(this).data("id");

    var products = productsInCart();

    if(products){
        if(alreadyInCart()){
            update();
        }else {
            addToStorage();
        }
    }else{
        firstInStorage();
    }

    function alreadyInCart(){
        return products.filter(product => product.id == id).length;
    }

    function addToStorage() {
        let products = productsInCart();
        products.push({
            id : id,
            quantity : 1
        });
        localStorage.setItem("products", JSON.stringify(products));
    }

    function update(){
        let products = productsInCart();
        for(let product in products){
            if(products[product].id == id){
                products[product].quantity++;
                break;
            }
        }
        localStorage.setItem("products", JSON.stringify(products));
    }

    function firstInStorage(){
        let products = [];
        products[0] = {
            id : id,
            quantity : 1
        };
        localStorage.setItem("products", JSON.stringify(products));
    }
    $("#cart-count").html(++products.length);
}

function displayErrors(errors){
    let html = "";
    errors.forEach(function(err){
        html += singleError(err);
    });
    $("#errors").html(html);
}
function singleError(err){
    return `<div class="p-4 border mb-3">
    <span class="d-block text-primary h6 text-uppercase">New York</span>
    <p class="mb-0">${err}</p>
  </div>`;
}
function downloadWordFile(e){
    e.preventDefault(e);
    $.ajax({
        url: 'models/admin/users/download-word.php',
        method: 'POST',
        dataType: 'json',
        data: {
            send: true
        },
        success: function(data, status, request){
            alert("Uspesno ste preuzeli word dokument.");
        },
        error: ajaxErrors
    });
}

function checkLogin(e){
    e.preventDefault();

    let username = $("#login_username").val().trim();
    let password = $("#login_password").val().trim();

    if(username != "" || password != ""){
        $.ajax({
            url: 'models/users/login.php',
            method: 'POST',
            dataType: 'json',
            data: {
                username: username,
                password: password,
                send: true
            },
            success: function(data, status, request){
                if(data == "pogresno"){
                    alert("Uneti su pogresni parametri");
                }else {
                    $(document).scrollTop(0);
                    document.location.reload(true);
                    alert("Uspesan login");
                }

            },
            error: ajaxErrors
        });
    }else {
        alert("Polja za login ne smeju biti prazna.");
    }


}
var errors = false;
function checkForUsername(){
    let username = $(this).val().trim();
    if(username != ""){
        $.ajax({
            url: 'models/users/check_username.php',
            method: 'POST',
            dataType: 'json',
            data: {
                username_value: username,
                send: true
            },
            success: function(data, status, request){
                $flag = data;
                if($flag){
                    $("#c_username").css("border", "1px solid red");
                    $("#c_username").val("Korisnicko ime vec postoji.");
                    errors = true;
                }else {
                    $("#c_username").css("border", "");
                    errors = false;
                }
            },
            error: ajaxErrors
        });
    }
}
function checkForEmail(){
    let email = $(this).val().trim();
    if(email != ""){
        $.ajax({
            url: 'models/users/check_email.php',
            method: 'POST',
            dataType: 'json',
            data: {
                email_value: email,
                send: true
            },
            success: function(data, status, request){
                $flag = data;
                if($flag){
                    $("#c_email").css("border", "1px solid red");
                    $("#c_email").val("E-mail vec postoji.");
                    errors = true;
                }else {
                    $("#c_email").css("border", "");
                    errors = false;
                }
            },
            error: ajaxErrors
        });
    }
}
function checkPasswordFields(){
    let password = $("#c_password").val();
    let re_password = $("#c_password_repeat").val();

    let reg_password = /^((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W])).{8,}$/;


    if(!reg_password.test(password)){
        errors = true;
        $("#c_password").css("border", "1px solid red");
        $("#c_password_repeat").attr("disabled", "true");
    }else {
        $("#c_password").css("border", "");
        $("#c_password_repeat").removeAttr("disabled");
    }
}
function sendData(e){
    e.preventDefault();

    let f_name = $("#c_fname").val().trim();
    let l_name = $("#c_lname").val().trim();
    let email = $("#c_email").val().trim();
    let username = $("#c_username").val().trim();
    let password = $("#c_password").val().trim();
    let re_password = $("#c_password_repeat").val().trim();
    let data = [];

    let reg_f_name = /^[A-Z]\w{2,9}$/;
    let reg_l_name = /^[A-Z]\w{2,9}(\s[A-Z]\w{2,9})?$/;
    let reg_email = /^([a-z0-9][-a-z0-9_\+\.]*[a-z0-9])@(ict\.edu|gmail|yahoo)\.(rs|com)$/;
    let reg_username = /^((?=.*\d)(?=.*[a-z])).{8,}$/;
    let reg_password = /^((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W])).{8,}$/;


    //provera imena
    if(f_name == ""){
        errors = true;
        $("#c_fname").val("Morate uneti ime.");
        $("#c_fname").css("border", "1px solid red");
    }
    else if(!reg_f_name.test(f_name)){
        errors = true;
        $("#c_fname").val("Niste uneli ime kako treba.");
        $("#c_fname").css("border", "1px solid red");
    }else {
        errors = false;
        $("#c_fname").css("border", "");
    }
    //provera prezimena
    if(l_name == ""){
        errors = true;
        $("#c_lname").val("Morate uneti prezime.");
        $("#c_lname").css("border", "1px solid red");
    }
    else if(!reg_l_name.test(l_name)){
        errors = true;
        $("#c_lname").val("Niste uneli prezime kako treba.");
        $("#c_lname").css("border", "1px solid red");
    }else {
        errors = false;
        $("#c_lname").css("border", "");
    }
    //provera e-mail adrese
    if(email == ""){
        errors = true;
        $("#c_email").val("Morate uneti e-mail.");
        $("#c_email").css("border", "1px solid red");
    }
    else if(!reg_email.test(email)){
        errors = true;
        $("#c_email").val("Niste uneli e-mail kako treba.");
        $("#c_email").css("border", "1px solid red");
    }else {
        errors = false;
        $("#c_email").css("border", "");
    }
    //provera korisnickog imena
    if(username == ""){
        errors = true;
        $("#c_username").val("Morate uneti korisnicko ime.");
        $("#c_username").css("border", "1px solid red");
    }
    else if(!reg_username.test(username)){
        errors = true;
        $("#c_username").val("Niste uneli korisnicko ime kako treba.");
        $("#c_username").css("border", "1px solid red");
    }else {
        errors = false;
        $("#c_username").css("border", "");
    }
    //provera sifre
    if(password == ""){
        errors = true;
        alert("Morate uneti sifru.");
        $("#c_password").css("border", "1px solid red");
    }
    else {
        errors = false;
        $("#c_password").css("border", "");
    }
    if(re_password == ""){
        alert("Morate ponoviti sifru.");
    }
    else if(password != re_password){
        errors = true;
        alert("Sifre moraju biti iste.");
        $("#c_password_repeat").css("border", "1px solid red");
    }else {
        $("#c_password_repeat").css("border", "");
    }

    if(!errors){
    $.ajax({
        url: 'models/users/insert.php',
        method: 'POST',
        dataType: 'json',
        data: {
            f_name: f_name,
            l_name: l_name,
            email: email,
            username: username,
            password: password,
            send: true
        },
        success: function(data, status, request){
            let podaci = data;
            alert("Uspesno ste napravili nalog !");
        },
        error: ajaxErrors
    });
    }else {
        alert("Nisu uneti ispravni parametri.");
    }
 
}
function ajaxErrors(err, status, statusText){
    console.error("AJAX ERROR: ");
    console.log(status);
    console.log(statusText);

    if(err.status == 500){
        console.log(err.parseJSON);
    }else if(err.status == 400){
        alert("Nisu poslati ispravni parametri !");
    }
}