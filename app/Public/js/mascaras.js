$(function () {
    $(".data").mask("99/99/9999", { placeholder: "__/__/____" });
    $(".cpf").mask("999.999.999-99", { placeholder: " " });
    $(".telefone").mask("(99) 99999-9999", { placeholder: " " });
    $(".cnpj").mask("99.999.999/9999-99", { placeholder: "() -" });
    $(".rg").mask("999999999999999", { placeholder: " " });
    $(".rg").mask("99999999999", { placeholder: " " });
    $(".hora").mask("99:99", { placeholder: "" });
    $(".cep").mask("99999-999", { placeholder: "" });
});
