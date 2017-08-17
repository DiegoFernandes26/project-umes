$(document).ready(function () {
    $(".button-collapse").sideNav();
    $('.modal').modal();

    // $('.tap-target').tapTarget('open');
    // $('.tap-target').tapTarget('close');

    $("#menu").click(function () {
        $(".container-cad").fadeToggle();
    });

    $('.datepicker').pickadate({
        format: 'mm/dd/yyyy',
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15 // Creates a dropdown of 15 years to control year
    });

    // $(".dinheiro").maskMoney({showSymbol: true, symbol: "R$ ", decimal: ",", thousands: "."});

    $('.cpf-valida').mask('000.000.000-00');
    $('.celular-valida').mask('(00)00000-0000');
    $('.fixo-valida').mask('(00)0000-0000');
    $('.validade-valida').mask('00/00');

//    arrastar foto
//     $(".draggable").draggable();

});

// traduzir para pt-br o campo data
$('.datepicker').pickadate({
    monthsFull: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
    monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
    weekdaysFull: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sabádo'],
    weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
    today: 'Hoje',
    clear: 'Limpar',
    close: 'Pronto',
    labelMonthNext: 'Próximo mês',
    labelMonthPrev: 'Mês anterior',
    labelMonthSelect: 'Selecione um mês',
    labelYearSelect: 'Selecione um ano',
    selectMonths: true,
    selectYears: 15,
    format: 'mm/dd/yyyy',
});


$(document).ready(function () {
    $('select').material_select();

});

$(".carrega-load").click(function () {
    $(".carrega").fadeIn();
});


//cep

$(document).ready(function () {

    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#rua").val("");
        $("#bairro").val("");
        $("#cidade").val("");
        $("#uf").val("");
    }

    //Quando o campo cep perde o foco.
    $("#cep").blur(function () {
        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if (validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#rua").val("Carregando...");
                $("#bairro").val("Carregando...");
                $("#cidade").val("Carregando...");
                $("#uf").val("Carregando...");

                //Consulta o webservice viacep.com.br/
                $.getJSON("//viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#rua").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#uf").val(dados.uf);
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        $('.conteudo-modal').html('O cep inserido não foi encontrado, por favor verifique o número inserido');
                        $('.modal-titulo').html('CEP não encontrado');
                        $('#aviso-modal').modal('open');
                        $('#cep').focus();
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                $('.conteudo-modal').html('Por favor verifique o formato do CEP inserido');
                $('.modal-titulo').html('Formato de CEP inválido');
                $('#aviso-modal').modal('open');
                $('#cep').focus();


            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    });
});

//fim do cep

//busca inteligente
$(function () {
    $("#busca-campo").keyup(function () {
        var texto = $(this).val();
        $("#collection-item li").css("display", "block");
        $("#collection-item li").each(function () {
            if ($(this).text().indexOf(texto) < 0)
                $(this).attr("style", "display: none !important");
        });
    });
});

//valida cpf
$(".cpf-valida").blur(function () {
    if (valida_cpf(document.getElementById('cpf').value)) {
        $('.cpf-valida').css('background', 'transparent');
    } else {
        $('.cpf-valida').css('background', '#e57373');
    }
});
function valida_cpf() {
    var cpf = $('.cpf-valida').val();
    cpf = cpf.replace('.', '');
    cpf = cpf.replace('.', '');
    cpf = cpf.replace('-', '');
    var numeros, digitos, soma, i, resultado, digitos_iguais;
    digitos_iguais = 1;
    if (cpf.length < 11)
        return false;
    for (i = 0; i < cpf.length - 1; i++)
        if (cpf.charAt(i) != cpf.charAt(i + 1)) {
            digitos_iguais = 0;
            break;
        }
    if (!digitos_iguais) {
        numeros = cpf.substring(0, 9);
        digitos = cpf.substring(9);
        soma = 0;
        for (i = 10; i > 1; i--)
            soma += numeros.charAt(10 - i) * i;
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0))
            return false;
        numeros = cpf.substring(0, 10);
        soma = 0;
        for (i = 11; i > 1; i--)
            soma += numeros.charAt(11 - i) * i;
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1))
            return false;
        return true;
    }
    else
        return false;
}
//valida cpf


$(document).ready(function () {

    //carregar thumb
    $('#foto').on('change', function () { //on file input change
        if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
        {
            $('#foto-perfil').html(''); //clear html of output element
            var data = $(this)[0].files; //this file data
            $.each(data, function (index, file) { //loop though each file
                if (/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)) { //check supported file type
                    var fRead = new FileReader(); //new filereader
                    fRead.onload = (function (file) { //trigger function on successful read
                        return function (e) {
                            var img = $('<img/>').addClass('thumb').attr('src', e.target.result); //create image element
                            $('#foto-perfil').append(img); //append image to output element
                            $('.fotoPreview-perfil').fadeIn(7000);
                        };
                    })(file);
                    fRead.readAsDataURL(file); //URL representing the file's data.
                }
            });
        } else {
            alert("Seu navegador não tem suporte a pre carregamento de imagem"); //if File API is absent
        }
    });


    $('#rg-frente').on('change', function () { //on file input change
        if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
        {
            $('#rg-frente-preview').html(''); //clear html of output element
            var data = $(this)[0].files; //this file data
            $.each(data, function (index, file) { //loop though each file
                if (/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)) { //check supported file type
                    var fRead = new FileReader(); //new filereader
                    fRead.onload = (function (file) { //trigger function on successful read
                        return function (e) {
                            var img = $('<img/>').addClass('thumb').attr('src', e.target.result); //create image element
                            $('#rg-frente-preview').append(img); //append image to output element
                            $('.rg-frente-preview').fadeIn(7000);
                        };
                    })(file);
                    fRead.readAsDataURL(file); //URL representing the file's data.
                }
            });
        } else {
            alert("Seu navegador não tem suporte a pre carregamento de imagem"); //if File API is absent
        }
    });


    $('#rg-verso').on('change', function () { //on file input change
        if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
        {
            $('#rg-verso-preview').html(''); //clear html of output element
            var data = $(this)[0].files; //this file data
            $.each(data, function (index, file) { //loop though each file
                if (/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)) { //check supported file type
                    var fRead = new FileReader(); //new filereader
                    fRead.onload = (function (file) { //trigger function on successful read
                        return function (e) {
                            var img = $('<img/>').addClass('thumb').attr('src', e.target.result); //create image element
                            $('#rg-verso-preview').append(img); //append image to output element
                            $('.rg-verso-preview').fadeIn(7000);
                        };
                    })(file);
                    fRead.readAsDataURL(file); //URL representing the file's data.
                }
            });
        } else {
            alert("Seu navegador não tem suporte a pre carregamento de imagem"); //if File API is absent
        }
    });

    $('#matricula').on('change', function () { //on file input change
        if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
        {
            $('#matricula-preview').html(''); //clear html of output element
            var data = $(this)[0].files; //this file data
            $.each(data, function (index, file) { //loop though each file
                if (/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)) { //check supported file type
                    var fRead = new FileReader(); //new filereader
                    fRead.onload = (function (file) { //trigger function on successful read
                        return function (e) {
                            var img = $('<img/>').addClass('thumb').attr('src', e.target.result); //create image element
                            $('#matricula-preview').append(img); //append image to output element
                            $('.matricula-preview').fadeIn(7000);
                        };
                    })(file);
                    fRead.readAsDataURL(file); //URL representing the file's data.
                }
            });
        } else {
            alert("Seu navegador não tem suporte a pre carregamento de imagem"); //if File API is absent
        }
    });
//função carregar thumb
});


//carteira preview
function each(arr, callback) {
    var length = arr.length;
    var i;

    for (i = 0; i < length; i++) {
        callback.call(arr, arr[i], i, arr);
    }

    return arr;
}

window.addEventListener('DOMContentLoaded', function () {
    var image = document.querySelector('#image');
    var previews = document.querySelectorAll('.preview');
    var cropper = new Cropper(image, {
        ready: function () {
            var clone = this.cloneNode();

            clone.className = ''
            clone.style.cssText = (
                'display: block;' +
                'width: 100%;' +
                'min-width: 0;' +
                'min-height: 0;' +
                'max-width: none;' +
                'max-height: none;'
            );

            each(previews, function (elem) {
                elem.appendChild(clone.cloneNode());
            });
        },

        crop: function (e) {
            var data = e.detail;
            var cropper = this.cropper;
            var imageData = cropper.getImageData();
            var previewAspectRatio = data.width / data.height;

            each(previews, function (elem) {
                var previewImage = elem.getElementsByTagName('img').item(0);
                var previewWidth = elem.offsetWidth;
                var previewHeight = previewWidth / previewAspectRatio;
                var imageScaledRatio = data.width / previewWidth;

                elem.style.height = previewHeight + 'px';
                previewImage.style.width = imageData.naturalWidth / imageScaledRatio + 'px';
                previewImage.style.height = imageData.naturalHeight / imageScaledRatio + 'px';
                previewImage.style.marginLeft = -data.x / imageScaledRatio + 'px';
                previewImage.style.marginTop = -data.y / imageScaledRatio + 'px';
            });
        }
    });
});


//função para confirmar exclusão modal

function deletar_modal(id, name) {
    $('#excluir').modal('open');
    $("#item").html(name);
    var bt_excluir = "<a href='destroy/" + id + "' class='btn modal-action waves-effect red darken-1'>Confirmar</a>";
    $("#confirmar-footer").html(bt_excluir);

}


function editar_modal(id) {
    $('#edit-item').modal('open');
    $('#titulo-modal').html('Editar curso');
    $("#content-edit").load("/admin/cursos/edit/" + id + " #container", function(){
        $('select').material_select();
    });
    $('.carregamento').fadeOut();
}


//validação do campo data de expiração
$(".validade-valida").blur(function () {
    var data = $(".validade-valida").val();
    var dia = data.split("/");
    if (data.length == 5) {
        // alert(dia[0]+" - "+dia[1]);
        if (dia[0] < 1 || dia[0] > 31) {
            $('.validade-valida').css('background', '#e57373');
            $(".validade-valida").focus();
            $('#edit-item').modal('open');
            $('#titulo-modal').html("Erro");
            $('#content-edit').html("O dia de vencimento precisa ser um valor válido.");


        } else if (dia[1] < 1 || dia[1] > 12) {
            $('.validade-valida').css('background', '#e57373');
            $(".validade-valida").focus();
            $('#edit-item').modal('open');
            $('#titulo-modal').html("Erro");
            $('#content-edit').html("O mês de vencimento precisa ser um valor válido.");
        } else {
            $('.validade-valida').css('background', 'transparent');
        }

    }else{
        $(".validade-valida").focus();
        $('#edit-item').modal('open');
        $('#titulo-modal').html("Erro");
        $('#content-edit').html("Preencha corretamente o campo data de expiração.");

    }
});