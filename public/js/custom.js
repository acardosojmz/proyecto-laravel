function preview(event, divDestination){
    for (let file of event.target.files){
        let src = URL.createObjectURL(file);
        let iframe = document.createElement("iframe");
        iframe.src = src;
        var destination = document.getElementById(divDestination);
        destination.appendChild(iframe);
        destination.style.display = "block";
    };
}
/*
function preview(event, destination){
    if(event.target.files.length > 0){
        let src = URL.createObjectURL(event.target.files[0]);
        let prevDestination = document.getElementById(destination);
        prevDestination.src = src;
        prevDestination.style.display = "block";
    }
}
*/            
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
