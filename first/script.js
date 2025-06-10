let headerInter = ""

function start() {

    headerInter = document.querySelector('.header-interface > span:not([selected])')

    headerInter.addEventListener("click", headerInterface)

}

function headerInterface() {
    var tmpHeaderInter = document.querySelector('.header-interface > span[selected]')

    tmpHeaderInter.removeAttribute("selected")
    headerInter.setAttribute("selected", "")

    headerInter.removeEventListener("click", headerInterface)

    headerInter = document.querySelector('.header-interface > span:not([selected])')
    headerInter.addEventListener("click", headerInterface)
}


window.addEventListener("load", start)