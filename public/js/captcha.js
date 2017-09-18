$('#captcha').on('click',function () {
    var captcha = $(this);
    var url = '/captcha/'+captcha.attr('data-captcha-config')+'/?'+Math.random();
    captcha.attr('src',url);
});