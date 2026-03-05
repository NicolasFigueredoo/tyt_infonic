export const borrarImg = (tipo,id) => {
    let img = document.getElementById(tipo+id)
    let imgHidden = document.getElementById(tipo+'Hidden'+id)
    console.log(imgHidden.value)
    let btn = document.getElementById(tipo+'btn'+id)
    img.remove()
    imgHidden.remove()
    btn.remove()
    
}