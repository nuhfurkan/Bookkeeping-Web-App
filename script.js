function onClickToTheAramaYap() {

    console.log("merhaba");

    var elem = document.getElementById("contentTable");
    elem.innerHTML = "";
    
    addNewLineToTable(elem);
}

function addNewLineToTable(elem) {
    var newlineElem = document.createElement("TR")  
    elem.appendChild(newlineElem);

    var newEntryDate = document.createElement("TH");
    newEntryDate.innerHTML = "aciklama"
    newlineElem.appendChild(newEntryDate);

    var newEntryDate = document.createElement("TH");
    newEntryDate.innerHTML = "tarih"
    newlineElem.appendChild(newEntryDate);

    var newEntryName = document.createElement("TH");
    newEntryName.innerHTML = "isim"
    newlineElem.appendChild(newEntryName);

    var newEntryAm = document.createElement("TH");
    newEntryAm.innerHTML = "tutar"
    newlineElem.appendChild(newEntryAm);

    var newEntrySp = document.createElement("TH");
    newEntrySp.innerHTML = "cins"
    newlineElem.appendChild(newEntrySp);

    var newEntryDel = document.createElement("TH");
    newEntryDel.innerHTML = "sil"
    newlineElem.appendChild(newEntryDel);
} 

function showData() {
    var kisiIsim = document.getElementById("kisiListesi").value;
    console.log("kisiIsim ->"+kisiIsim);
    var dovizIsim = document.getElementById("dövizListesi").value;
    console.log("dovizIsim ->" +dovizIsim);
    var islemIsim = document.getElementById("islemler").value;
    console.log("islemIsim ->" +islemIsim);

    const xhttp = new XMLHttpRequest();
    var elem = document.getElementById("contentTable");
    xhttp.onload = function() {
        console.log("isim -> " + kisiIsim);
        elem.innerHTML = "";
        addNewLineToTable(elem);
        var arr = this.responseText.split("@@");
        setKasaBakiye(arr[1]);
        elem.innerHTML += arr[0];
    }
    xhttp.open("GET", "getData.php?kisi="+kisiIsim+"&doviz="+dovizIsim+"&islem="+islemIsim);
    xhttp.send();
}

function yeniDovizOlustur() {
    const xhttp = new XMLHttpRequest();
    var elem = document.getElementById("yeniDovizIsim").value;
    xhttp.onload = function() {
        setNewValues()
        document.getElementById("yeniDovizIsim").value = null;
    }
    xhttp.open("GET", "yeniDoviz.php?q="+elem);
    xhttp.send();

    alert("Su dövizi olusturdunuz:\n" + elem)
}

function yeniKisiOlustur() {
    const xhttp = new XMLHttpRequest();
    var kisiisim = document.getElementById("yeniKisiIsim").value;
    xhttp.onload = function() {
        setNewValues();
        document.getElementById("yeniKisiIsim").value = null;
    }
    xhttp.open("GET", "yeniKisi.php?isim="+kisiisim);
    xhttp.send();

    alert("Su kisiyi olusturdunuz:\n" +kisiisim.replace(new RegExp("@", "g"), " "));
}

function yeniIslemOlustur() {
    const xhttp = new XMLHttpRequest();

    var kisiisim = document.getElementById("islemKisiListesi").value;
    var dovizisim = document.getElementById("islemDövizListesi").value;
    var islemturu = document.getElementById("islemTuru").value;
    var tutar = document.getElementById("islemTutar").value;
    var aciklama = document.getElementById("description").value;

    //kisibakiye = parseInt(kisibakiye);
    xhttp.onload = function() {        
        console.log(this.responseText);
        document.getElementById("islemTutar").value = null;
        console.log(this.responseText);
    }
    xhttp.open("GET", "yeniIslem.php?isim="+kisiisim+"&doviz="+dovizisim+"&tur="+islemturu+"&tutar="+tutar+"&aciklama="+aciklama);
    xhttp.send();

    alert("Su islemi yaptiniz: \n"+"Ilgili kisi: "+ kisiisim.replace(new RegExp("@", 'g'), " ")+"\n"+islemturu +" -> "+ tutar+"("+dovizisim+")")
}

function setNewValues(str) {
    const xhttpkisi = new XMLHttpRequest();
    xhttpkisi.onload = function() {

        document.getElementById("kisiListesi").innerHTML = "<option value=\"hepsi\" selected >hepsi</option>" + this.responseText;
        console.log(this.responseText);
        document.getElementById("islemKisiListesi").innerHTML = this.responseText;
    }
    xhttpkisi.open("GET", "setKisiler.php");
    xhttpkisi.send();

    const xhttpdoviz = new XMLHttpRequest();
    xhttpdoviz.onload = function() {
        
        document.getElementById("dövizListesi").innerHTML = "<option value=\"hepsi\" selected>hepsi</option>" + this.responseText;
        console.log(this.responseText);
        document.getElementById("islemDövizListesi").innerHTML = this.responseText;
    }
    xhttpdoviz.open("GET", "setDovizler.php");
    xhttpdoviz.send();

    setKasaBakiye();


}

function setKasaBakiye(str) {
    if (str == undefined) {
        str = "";
    }
    document.getElementById("kasabalance").innerHTML = str;
}

function bodyInit() {
    setNewValues();
}

function sil(str) {

    if (confirm("Silmek istediginizden emin misiniz?")) {
      } else {
        return;
      }

    const newxhttp = new XMLHttpRequest();
    newxhttp.onload = function() {
        showData();
        setKasaBakiye();
    }
    newxhttp.open("GET", "silIslem.php?q="+str);
    newxhttp.send();
}

function popUpFunction(elem) {
    var popup = document.getElementById(elem);
    popup.classList.toggle("show");
}