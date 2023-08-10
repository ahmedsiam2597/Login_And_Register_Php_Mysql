document.querySelectorAll('input').forEach(el=>{
    el.addEventListener('focus' , ()=>{
        el.setAttribute('data-placeholder' , el.getAttribute('placeholder'));
        el.setAttribute('placeholder' , '');
    });
    el.addEventListener('blur' , ()=>{
        el.setAttribute('placeholder' , el.dataset.placeholder);
    });
})