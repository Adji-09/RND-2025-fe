API_TOKEN = "de9d4dd7a5424e128c78d477252623a2"

function add_person(name, image, collections, callback){
    var myHeaders = new Headers();
    myHeaders.append("token", API_TOKEN);

    var formdata = new FormData();
    formdata.append("name", name);

    if ((typeof image == "string") && (image.indexOf("https://") == 0))
        formdata.append("photos", image);
    else
        formdata.append("photos", image, "file");

    formdata.append("store", "1");
    formdata.append("collections", collections);

    var requestOptions = {
      method: 'POST',
      headers: myHeaders,
      body: formdata,
      redirect: 'follow'
    };

    fetch("https://api.luxand.cloud/v2/person", requestOptions)
      .then(response => response.json())
      .then(result => callback(result))
      .catch(error => console.log('error', error));
}

function add_face(person_uuid, image, callback){
    var myHeaders = new Headers();
    myHeaders.append("token", API_TOKEN);

    var formdata = new FormData();

    if ((typeof image == "string") && (image.indexOf("https://") == 0))
        formdata.append("photos", image);
    else
        formdata.append("photos", image, "file");

    formdata.append("store", "1");

    var requestOptions = {
      method: 'POST',
      headers: myHeaders,
      body: formdata,
      redirect: 'follow'
    };

    fetch("https://api.luxand.cloud/v2/person/" + person_uuid, requestOptions)
      .then(response => response.json())
      .then(result => callback(result))
      .catch(error => console.log('error', error));
}

function verify(person_uuid, image, callback){
    var myHeaders = new Headers();
    myHeaders.append("token", API_TOKEN);

    var formdata = new FormData();

    if ((typeof image == "string") && (image.indexOf("https://") == 0))
        formdata.append("photo", image);
    else
        formdata.append("photo", image, "file");

    var requestOptions = {
      method: 'POST',
      headers: myHeaders,
      body: formdata,
      redirect: 'follow'
    };

    fetch("https://api.luxand.cloud/photo/verify/" + person_uuid, requestOptions)
      .then(response => response.json())
      .then(result => callback(result))
      .catch(error => console.log('error', error));
}
