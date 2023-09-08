
document.getElementById("year").innerHTML = new Date().getFullYear();

let calculate_age = function() {
    birthdate = new Date("2005-09-30");
    today = new Date();

    age = today.getFullYear() - birthdate.getFullYear();

    if (today.getMonth() < birthdate.getMonth() || (today.getMonth() == birthdate.getMonth() && today.getDate() < birthdate.getDate())) {
        age--;
        }

    document.getElementById("age_display").innerHTML = age;
}