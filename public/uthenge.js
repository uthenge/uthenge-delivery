var uthengeQuotation = {
  form: '#quotation-form',
  add: function(name){
    var inputGroup = document.createElement("div")
    inputGroup.classList.add("input-group","mb-3")
    var inputElement = document.createElement("input")
    inputElement.setAttribute("placeholder","Item")
    inputElement.classList.add("form-control")
    inputElement.setAttribute("name","item")
    inputElement.value = name
    inputGroup.appendChild(inputElement)
    var button = document.createElement("button")
    button.classList.add("btn","btn-outline-danger")
    button.setAttribute("type","button")
    button.setAttribute("onclick",`uthengeQuotation.remove(${inputGroup});`)
    button.innerText = "Remove"
    inputGroup.appendChild(button)
    document.querySelector(this.form).appendChild(inputGroup)
  },
  remove: function(childNode){
    document.querySelector(this.form).removeChild(childNode)
  },
  submit: function(){
    document.querySelector(this.form).submit()
  }
}