function retrieveId(elementClass, elementClassId)
{
    var lengthClass = elementClass.length;
    var lengthClassId = elementClassId.length;
    var id = elementClassId.substr(lengthClass, (lengthClassId-lengthClass));
    return id;
}