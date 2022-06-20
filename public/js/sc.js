function Loading(e, label) {
    this.e = $(e);
    this.text = this.e.text();
    this.label = label;
    this.set = ()=>{
        this.e.attr('disabled', '');
        this.e.html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <span class="visually-hidden">${ this.label ?? 'Loading...' }</span>`)
    }
    this.unset = ()=>{
        this.e.removeAttr('disabled');
        this.e.html(this.text)
    }
}
function correction(e) {
    e.preventDefault();
    const { chooseId, charsId } = this.dataset;
    const char = $(this).find(`input:checked`);
    const form = new FormData();
    const btnCheck = $(this).find(`button:submit`);
    const loading = new Loading(btnCheck, 'Wait..'); 
    loading.set();
    form.append('_token', this[0].value);
    form.append('chars_id', charsId);
    form.append('choose', char.val());
    fetch(`/chooses/${chooseId}`, {
        method: 'post',
        body: form,
    }).then(a=>a.json())
    .then(res=>{
        $(this).find('.is-invalid').removeClass('is-invalid');
        $(this).find('.is-valid').removeClass('is-valid');
        if(res.choosed != res.correct) $(this).find(`input[value=${res.choosed}]`).addClass('is-invalid')
        $(this).find(`input[value=${res.correct}]`).addClass('is-valid')
        loading.unset();
    });
}
const formChars = $('#formChars')
formChars.submit(()=>{
    const loading = new Loading($(formChars).find('button:submit'));
    loading.set();
})
const formTest = $('form[id=formAnswer]');
formTest.submit(correction);
checkAllBtn = $('#checkAll');
checkAllBtn.click(()=>{
    const checkAllLoading = new Loading(checkAllBtn);
    let notValid = 0;
    for (const ft of formTest) {
        if(!ft.checkValidity()) notValid++;
    }
    if(notValid){
        let text = checkAllBtn.text();
        checkAllBtn.html(`<span class="text-warning">Isi semua jawaban terlebih dahulu.</span>`);
        return setTimeout(() => {
            checkAllBtn.html(text);
        }, 2000);
    }
    checkAllLoading.set();
    formTest.submit();
    setTimeout(checkAllLoading.unset, 3000);
})
