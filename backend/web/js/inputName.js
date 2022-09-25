function checkNameShelf()
{
    var shelf = document.getElementById("shelf-name").value;
    var name = checkInput(shelf);
    if (name === "False")
    {
        return false;
    }
}

function checkNameCupboards()
{
    var cupboards = document.getElementById("cupboards-name").value;
    var name = checkInput(cupboards);
    if (name === "False")
    {
        return false;
    }
}

function checkInput(name)
{
    var regex = new RegExp("^([a-z]|[A-Z]|[0-9]|[_-])*$");

    if (!regex.test(name))
    {
        alert("Name không chứa khoảng trắng và kí tự đặt biệt, có thể chứa [ _- ] !!! ");
        return name = "False";
    }
}

function checkDirectoryExist()
{
    alert("Directory exist!!!");
}