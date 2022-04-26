function previewImage(event, imageId){
    if(event.target.files.length > 0){
      let src = URL.createObjectURL(event.target.files[0]);
      let imgPreview = document.getElementById(imageId);
      imgPreview.src = src;
      imgPreview.style.display = "block";
    }
  }

const validateSize = (fileId, maxSize)=>{
    let size= document.getElementById(fileId).files[0].size;
    console.log("SIZE:" + size);
    return (size<=maxSize);
}

const validateType= (fileId,...fileTypes)=>{
    const NOT_FOUND=-1;
    let type= document.getElementById(fileId).files[0].type;
    const upperCased = fileTypes.map(it => it.toUpperCase());
    return (upperCased.indexOf(type.toUpperCase()) !== NOT_FOUND); 
}
function validateData(){
    let isValid=true;
    if (!validateSize('foto',2048*1024)) {
        alert ("El tamaño de la foto debe ser menor a 2MB");
        isValid=false;
    }
    return isValid;
}
