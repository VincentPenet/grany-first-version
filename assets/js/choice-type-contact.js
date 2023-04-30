// Afficher le champ recherche lorsque le contact est connu
$('.knowContact').on('click', function () {
    $(".searchContact").toggleClass("hideKnowContact showKnowContact");
    $('.firstContact').toggleClass("hideFirstContact showFirstContact");
});

// ou le formulaire de contact si premier contact
$('.firstContact').on('click', function () {
    $(".formContact").toggleClass("hideFirstContact showFirstContact");
    $('.knowContact').toggleClass("hideKnowContact showKnowContact");
});
