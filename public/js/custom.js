function previewImage(event, imageId){
    if(event.target.files.length > 0){
      let src = URL.createObjectURL(event.target.files[0]);
      let imgPreview = document.getElementById(imageId);
      imgPreview.src = src;
      imgPreview.style.display = "block";
    }
  }

const validateSize = (imageId, maxSize)=>{
    let size= document.getElementById(imageId).files[0].size;
    return (size<=maxSize);
}
const validateType= (imageId,...fileTypes)=>{
    let type= document.getElementById(imageId).files[0].type;
    const upperCased = fileTypes.map(it => it.toUpperCase());
    return (upperCased.indexOf(type.toUpperCase()) !== -1); 
}
function validateData(){
    let isValid=true;
    if (!validateSize('foto',2048)) {
        alert ("El tamaño de la foto debe ser menor a 2MB");
        isValid=false;
    }
    return isValid;
}
