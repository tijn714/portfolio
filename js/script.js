let fetch_data_landingpage = function () {
    current_date = new Date();

    birth_date = new Date("2005/09/30");
    
    age = current_date.getFullYear() - birth_date.getFullYear();
    
    if (current_date.getMonth() < birth_date.getMonth() || current_date.getMonth() == birth_date.getMonth() && current_date.getDate() < birth_date.getDate()) {
        age--;
    }
    
    document.getElementById("age").innerHTML = age;
    document.getElementById("year").innerHTML = current_date.getFullYear(); 
}