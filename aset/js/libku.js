

jQuery(function($) {

	$('.tgl').mask('99/99/9999');
	$('.thn').mask('9999');

	$('.jam').mask('99:99');

	$(".ribuan").mask("#.##0", {reverse: true});

	$('.ribuan').css('text-align', 'right');

	$(".angka").numeric({ decimal : "," });

});





function ribuan(angka) {
        if (typeof(angka) != 'string') angka = angka.toString();

	var reg = new RegExp('([0-9]+)([0-9]{3})');

	while(reg.test(angka)) angka = angka.replace(reg, '$1.$2');

	return angka;
}



function balik_tanggal_sql(tgl){
	var tg = tgl.split("-"),
	h = tg[2],

	b =	tg[1],

	t = tg[0];
	var hasil = h+"/"+b+"/"+t;
	return hasil;
}



function replaceKoma(x){

	var hasil = x.replace(".",",")

	return hasil;

}



$('.angka-int').keyup(function(e){

	if (/\D/g.test(this.value))

	{

		this.value = this.value.replace(/\D/g, '');

	}

});





