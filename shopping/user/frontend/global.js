document.addEventListener("DOMContentLoaded", requestCategories);
function requestCategories(){
 fetch("http://localhost:8081/menu.php", {
  method: "GET", 
 }) 
  .then((res) => res.json())
  .then(data => {
   console.log(data);
  })
  .catch(err => console.log(err));
}
