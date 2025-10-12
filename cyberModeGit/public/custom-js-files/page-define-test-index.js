$('#filter').click(function(e) {
    var url='/admin/define-test?';
    var framework=$('#framework option:selected').val();
    var family=$('#family option:selected').val();
    var name=$('#name option:selected').val();
    if(framework){
        url=url+'framework='+framework+'&&';
    }
    if(family){
        url=url+'family='+family+'&&';
    }
    if(name){
        url=url+'name='+name;
    }
    window.location.href = url;
});