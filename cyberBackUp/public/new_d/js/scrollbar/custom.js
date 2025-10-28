var myElement = document.getElementById('');
new SimpleBar(myElement, { autoHide: true });

if (!window.matchMedia('(max-width: 480px)').matches) { new SimpleBar(myElement, { autoHide: true }); }