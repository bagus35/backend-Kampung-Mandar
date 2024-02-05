(function () {

    "use strict";

    var treeviewMenu = $('.app-menu');

    // Toggle Sidebar

    $('[data-toggle="sidebar"]').click(function (event) {

        event.preventDefault();

        $('.app').toggleClass('sidenav-toggled');

    });

    // Activate sidebar treeview toggle

    $("[data-toggle='treeview']").click(function (event) {

        event.preventDefault();

        if (!$(this).parent().hasClass('is-expanded')) {

            treeviewMenu.find("[data-toggle='treeview']").parent().removeClass('is-expanded');

        }

        $(this).parent().toggleClass('is-expanded');

        $('.subtreeview').removeClass('is-expanded');

    });

    // Set initial active toggle

    $("[data-toggle='treeview.'].is-expanded").parent().toggleClass('is-expanded');

    // Activate sidebar treeview toggle

    $("[data-toggle='subtreeview']").click(function (event) {

        event.preventDefault();

        if (!$(this).parent().hasClass('is-expanded')) {

            treeviewMenu.find("[data-toggle='subtreeview']").parent().removeClass('is-expanded');

        }

        $(this).parent().toggleClass('is-expanded');

    });

    // Set initial active toggle

    $("[data-toggle='subtreeview.'].is-expanded").parent().toggleClass('is-expanded');

    //Activate bootstrip tooltips

    $("[data-toggle='tooltip']").tooltip();

})();





jQuery(function($) {

	$('.tgl').mask('99/99/9999');
	$('.thn').mask('9999');

	$(".ribuan").mask("#.##0", {reverse: true});

	$('.ribuan').css('text-align', 'right');

	$(".angka").numeric({ decimal : "," });

});



function formatRibuan(angka){

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



