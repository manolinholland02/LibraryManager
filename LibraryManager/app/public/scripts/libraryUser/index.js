//функцията скрива/показва формата за заемане/връщане на книга при натискане ан съответния бутон
function toggleForm(formId) {
    //2-те форми за заемане/връщане на клинга имат този клас
    var forms = document.querySelectorAll('.initially-hidden');
    forms.forEach(function(form) {
        if (form.id === formId) {
            //ако дисплея на формата е скрит, покажи я, ако не-скрий я
            //и задай тази стойност
            form.style.display = (form.style.display === 'none' ? 'block' : 'none');
        } else {
            //ако не е това формата, направо я скривай
            form.style.display = 'none';
        }
    });
}