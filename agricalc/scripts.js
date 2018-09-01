(function(window){
    $(document).ready(function(){
        var recalc = function (){
            
            var apu = Number($("#inputPerUnit").val()) || 1;
            var tu  = Number($("#inputTargetUnits").val()) || 1; 
            var app = Number($("#inputAmountPerPackage").val()) || 1;
            var cpp = Number($("#inputCostPerPackage").val()) || 1;
            var tv  = Number($("#inputTargetVolume").val()) || 1;
            

            var ru = apu * tu;
            var rp = Math.ceil(ru / app);
            var ac = Math.round(rp * cpp,2);
            var cc = Math.round(ac/tv,2);

            $("#targetAmount").text(ru);
            $("#targetPackages").text(rp);
            $("#targetCost").text(ac);
            $("#targetContainerCost").text(cc)
            //console.log([apu,tu,app,cpp,ru,rp,ac]);
        }
        $(".recalc").change(recalc);
        recalc();
        console.log("loaded");
    });
})(this);