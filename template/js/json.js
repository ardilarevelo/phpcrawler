function dejsonize(jsondata)
{
    var result;
    try {
        result = eval(jsondata);
    } catch(error) {
        alert('illegal JSON : \n' + error + 'in\n' + jsondata);
    }
    return result;
}