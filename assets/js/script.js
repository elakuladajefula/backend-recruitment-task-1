// Add your custom scripts here

console.log('Good luck 👌');

let fname = document.querySelector(".name");
let username = document.querySelector(".username");
let email = document.querySelector(".email");
let street = document.querySelector(".street");
let zipcode = document.querySelector(".zipcode");
let city = document.querySelector(".city");
let phone = document.querySelector(".phone");
let company = document.querySelector(".company");
let button = document.querySelector(".submitBtn");
button.disabled = true;
fname.addEventListener("change", stateHandle);
username.addEventListener("change", stateHandle);
email.addEventListener("change", stateHandle);
street.addEventListener("change", stateHandle);
zipcode.addEventListener("change", stateHandle);
city.addEventListener("change", stateHandle);
phone.addEventListener("change", stateHandle);
company.addEventListener("change", stateHandle);

function stateHandle() {
    if(fname.value === "" || username.value === "" || email.value === "" || street.value === "" || zipcode.value === "" || city.value === "" || phone.value === "" || company.value === "") {
        button.disabled = true;
    } else {
        button.disabled = false;
    }
}