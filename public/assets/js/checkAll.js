function checkAll(element) {
  var boxes = document.getElementsByTagName("input")
  let btnDltAll = document.getElementById("delete-all")
  for (var x = 0; x < boxes.length; x++) {
    var obj = boxes[x];
    if (obj.type == "checkbox") {
      if (obj.name != "check")
        obj.checked = element.checked
        if(element.checked){
          btnDltAll.classList.remove("d-none")
          btnDltAll.classList.add("d-block")
        }else{
          btnDltAll.classList.remove("d-block")
          btnDltAll.classList.add("d-none")
        }
    }
  }
}