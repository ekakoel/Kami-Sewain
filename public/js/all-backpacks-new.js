



$('button').click(function(e){
	e.preventDefault();
});




// Isotope

	var curPriceLow = 0;
	var curPriceHigh = 0;
	
	var product_type = ['.classic','.modern','.minimalist','.glamour','.artistic'];
	var product_category = ['.chair','.wtable','.decoration','.lighting','.glass','plate','gown'];
	var product_color = ['.blue','.green','.red','.gray','orange','black','pink','white','brown','yellow','purple'];
	var product_material = ['.wood','.stainless','.glass','.iron','plastic','acrilic','organic','cloth','ceramic','resin','purple'];

	var large_bag_names = ['eBagsMotherLode','OspreyPorter46','CabinMaxMetz','CabinMaxOxford'];
	var medium_bag_names = ['OspreyFarpoint40','TopPower8006','HynesEagle38l','CrazyAntsMilitary','Outlander'];
	var small_bag_names = ['Timbuk2Uptown','OspreyDaylite'];
	
	var large_bag_material = ['.nylon','.nylon','.nylon','.canvas'];
    var large_bag_sideHandle =['.syes','.syes','.sno','.sno'];
    var large_bag_waistStrap =['.wyes','.wyes','.wno','.wno'];

    var medium_bag_material = ['.nylon','.nylon','.polyester','.canvas','.nylon'];
    var medium_bag_sideHandle =['.syes','.sno','.syes','.syes','.sno'];
    var medium_bag_waistStrap =['.wyes','.wno','.wno','.wyes','.wno'];

    var small_bag_material = ['.nylon','.nylon'];
    var small_bag_sideHandle =['.syes','.sno'];
    var small_bag_waistStrap =['.wno','.wno'];
	
	// var msrplow =     [99,127,49,49,159,53,61,39,20,83,49];

    // var literList =  [45,46,44,44,40,35,38,40,33,30,13];

    // var lengthList =  [22,22,21.65,2.65,21,22,19.7,22,19,19.5,17.7];

	// var weightList =  [3.93,2.43,1.54,1.98,2.87,2.8,1.8,2.6,0.5,2.4,1];
	
	// var widthList =   [14,14,15.74,15.74,13,14,13,12,13,11.2,9.8];
	
	// var depthList =   [9,9,7.8,7.8,9,7.8,7.9,7.5,8.2,6.5,8.6];
	
	var mediumStart = 4;
	var smallStart = 9;
	var bag = '';
	
	var alreadyFilteredBags = [];
		


function initializeSliderHandlers() {
    //price
        $(".pricetemp-slider").slider({
            range: true,
            step: 10,
            min: 20,
            max: 160,
            values: [20,160],
            slide: function (event, ui) {
              $("#price-amount").val("<sup>$</sup>"+ui.values[ 0 ]+" - <sup>$</sup>"+ui.values[ 1 ]).digits();
              $('#price-low').html("<sup>$</sup>" + ui.values[0]).digits();
              $('#price-high').html("<sup>$</sup>" + ui.values[1]).digits();
              curPriceLow= ui.values[0];
              curPriceHigh = ui.values[1];
              checkPriceAndFilter();
            }
        });

        $('#price-low').html("<sup>$</sup>" + 20).digits();
        $('#price-high').html("<sup>$</sup>" + 160).digits();
        $( "#price-amount" ).val( "<sup>$</sup>" + 20 + " - <sup>$</sup>" + 160 ).digits();
}

function checkPriceAndFilter() {
        
        //Get min value and max value from slider
        var price_min = curPriceLow;
        var price_max = curPriceHigh;
        var temp = '';

        var chkMaterial = filters['material'];
        var chkColor = filters['color'];
        var chkType = filters['type'];
        var chkCategory = filters['category'];
        filters['price'] = '';

        // Check for type
        if (chkType == "classic") {
            var used = 0;
            for (i = 0; i < large_bag_names.length; i++) {
                if (typeof chkMaterial != 'undefined' && chkMaterial != "" && large_bag_material[i].match(chkMaterial) == null)
                    continue;

                if (typeof chkSideHandle != 'undefined' && chkSideHandle != "" && large_bag_sideHandle[i].match(chkSideHandle) == null)
                    continue;

                if (typeof chkWaistWrap != 'undefined' && chkWaistWrap != "" && large_bag_waistStrap[i].match(chkWaistWrap) == null)
                    continue;
                    
                var pricePassed = (msrplow[i] >= price_min && msrplow[i] <= price_max);
                if (pricePassed) {
                    if (used == 0) {
                        temp = temp + '.' + large_bag_names[i];
                        used = 1;
                    }
                    else
                        temp = temp + ', .' + large_bag_names[i];
                }
            }
            if (temp != "")
                filters["price"] = temp;
        }
        //Check for large
        if (chkCategory == '.large') {
            var used = 0;
            for (i = 0; i < large_bag_names.length; i++) {
                if (typeof chkMaterial != 'undefined' && chkMaterial != "" && large_bag_material[i].match(chkMaterial) == null)
                    continue;

                if (typeof chkSideHandle != 'undefined' && chkSideHandle != "" && large_bag_sideHandle[i].match(chkSideHandle) == null)
                    continue;

                if (typeof chkWaistWrap != 'undefined' && chkWaistWrap != "" && large_bag_waistStrap[i].match(chkWaistWrap) == null)
                    continue;
                    
                var pricePassed = (msrplow[i] >= price_min && msrplow[i] <= price_max);
                if (pricePassed) {
                    if (used == 0) {
                        temp = temp + '.' + large_bag_names[i];
                        used = 1;
                    }
                    else
                        temp = temp + ', .' + large_bag_names[i];
                }
            }
            if (temp != "")
                filters["price"] = temp;
        } //check for Tri-Fold
        else if (chkCategory == '.medium') {
            var used = 0;
            for (i = 0; i < medium_bag_names.length; i++) {

                if (typeof chkMaterial != 'undefined' && chkMaterial != "" && medium_bag_material[i].match(chkMaterial) == null)
                    continue;

                if (typeof chkSideHandle != 'undefined' && chkSideHandle != "" && medium_bag_sideHandle[i].match(chkSideHandle) == null)
                    continue;

                if (typeof chkWaistWrap != 'undefined' && chkWaistWrap != "" && medium_bag_waistStrap[i].match(chkWaistWrap) == null)
                    continue;

                var pricePassed = (msrplow[i+mediumStart] >= price_min && msrplow[i+mediumStart] <= price_max);
                
                
                if (pricePassed){

                    if (used == 0) {
                        temp = temp + '.' + medium_bag_names[i];
                        used = 1;
                    }
                    else
                        temp = temp + ', .' + medium_bag_names[i];
                }
            }

            filters["price"] = temp;
        } //check for duffel bags
        else if (chkCategory == '.small') {
            var used = 0;
            for (i = 0; i < small_bag_names.length; i++) {
            
                 if (typeof chkMaterial != 'undefined' && chkMaterial != "" && small_bag_material[i].match(chkMaterial) == null)
                    continue;

                if (typeof chkSideHandle != 'undefined' && chkSideHandle != "" && small_bag_sideHandle[i].match(chkSideHandle) == null)
                    continue;

                if (typeof chkWaistWrap != 'undefined' && chkWaistWrap != "" && small_bag_waistStrap[i].match(chkWaistWrap) == null)
                    continue;

                var pricePassed = (msrplow[i+smallStart] >= price_min && msrplow[i+smallStart] <= price_max);
                
            
                
                if (pricePassed){

                    if (used == 0) {
                        temp = temp + '.' + small_bag_names[i];
                        used = 1;
                    }
                    else
                        temp = temp + ', .' + small_bag_names[i];
                }
            }
            filters["price"] = temp;
        }
        //for all categories
        else {
            var used = 0;
            for (i = 0; i < large_bag_names.length; i++) {
                if (typeof chkMaterial != 'undefined' && chkMaterial != "" && large_bag_material[i].match(chkMaterial) == null)
                    continue;

                if (typeof chkSideHandle != 'undefined' && chkSideHandle != "" && large_bag_sideHandle[i].match(chkSideHandle) == null)
                    continue;

                if (typeof chkWaistWrap != 'undefined' && chkWaistWrap != "" && large_bag_waistStrap[i].match(chkWaistWrap) == null)
                    continue;
                    
                var pricePassed = (msrplow[i] >= price_min && msrplow[i] <= price_max);
                
                
                if (pricePassed) {
                    if (used == 0) {
                        temp = temp + '.' + large_bag_names[i];
                        used = 1;
                    }
                    else
                        temp = temp + ', .' + large_bag_names[i];
                }
            }
            
            for (i = 0; i < medium_bag_names.length; i++) {

                if (typeof chkMaterial != 'undefined' && chkMaterial != "" && medium_bag_material[i].match(chkMaterial) == null)
                    continue;

                if (typeof chkSideHandle != 'undefined' && chkSideHandle != "" && medium_bag_sideHandle[i].match(chkSideHandle) == null)
                    continue;

                if (typeof chkWaistWrap != 'undefined' && chkWaistWrap != "" && medium_bag_waistStrap[i].match(chkWaistWrap) == null)
                    continue;

                var pricePassed = (msrplow[i+mediumStart] >= price_min && msrplow[i+mediumStart] <= price_max);
               
            
                
                if (pricePassed){

                    if (used == 0) {
                        temp = temp + '.' + medium_bag_names[i];
                        used = 1;
                    }
                    else
                        temp = temp + ', .' + medium_bag_names[i];
                }
            }
            
            for (i = 0; i < small_bag_names.length; i++) {
            
                 if (typeof chkMaterial != 'undefined' && chkMaterial != "" && small_bag_material[i].match(chkMaterial) == null)
                    continue;

                if (typeof chkSideHandle != 'undefined' && chkSideHandle != "" && small_bag_sideHandle[i].match(chkSideHandle) == null)
                    continue;

                if (typeof chkWaistWrap != 'undefined' && chkWaistWrap != "" && small_bag_waistStrap[i].match(chkWaistWrap) == null)
                    continue;

                var pricePassed = (msrplow[i+smallStart] >= price_min && msrplow[i+smallStart] <= price_max);
               
            
                
                if (pricePassed){

                    if (used == 0) {
                        temp = temp + '.' + small_bag_names[i];
                        used = 1;
                    }
                    else
                        temp = temp + ', .' + small_bag_names[i];
                }
            }
            filters["price"] = temp;
        }

        if (filters["price"] == "")
            filters["price"] = 'none';

            
        //adhithya
        alreadyFilteredBags = [];
        var splitStr = filters["price"].split(",");
        for(var x in splitStr){
            alreadyFilteredBags.push(splitStr[x]);
        }

        filterValue = concatValues(filters);
        $grid.isotope({ filter: filterValue });
        
        
    }
	
var $grid;
// store filter for each group
var filters = {};
var $this;
var buttonGroup;
var filterGroup;
var filterValue;
$(window).load( function() {
    // init Isotope
    $grid = $('.grid').isotope({
        isInitLayout: false,
        itemSelector: '.product'
    });

    $('.filters').on('click', '.button', function () {
        $this = $(this);
        // get group key
        buttonGroup = $this.parents('.button-group');
        filterGroup = buttonGroup.attr('data-filter-group');
        // set filter for group
        filters[filterGroup] = $this.attr('data-filter');
        // combine filters
        //filters['price'] = '';
        filterValue = concatValues(filters);
        // set filter for Isotope
		
        var myString1 = $("#price-low").html();
        myString1 = myString1.replace(/\D/g, '');
        var myString2 = $("#price-high").html();
        myString2 = myString2.replace(/\D/g, '');
		
		curPriceLow = myString1;
		curPriceHigh = myString2;

        checkPriceAndFilter();
        //$grid.isotope({ filter: filterValue });

    });

    // change is-checked class on buttons
    $('.button-group').each(function (i, buttonGroup) {
        var $buttonGroup = $(buttonGroup);
        $buttonGroup.on('click', 'button', function () {
            $buttonGroup.find('.is-checked').removeClass('is-checked');
            $(this).addClass('is-checked');
        });
    });

    // Slider
    var lang = GetLanguageCode();
    if (lang == "en"){
        $.fn.digits = function(){ 
            return this.each(function(){ 
                $(this).text( $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") ); 
            })
        }

		initializeSliderHandlers();
		
		
		
    }else{
        $.fn.digits = function(){ 
            return this.each(function(){ 
                $(this).text( $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1 ") ); 
            })
        }
		
		initializeSliderHandlers();
    }


   
	var myString1 = $("#price-low").html();
        myString1 = myString1.replace(/\D/g, '');
        var myString2 = $("#price-high").html();
        myString2 = myString2.replace(/\D/g, '');
        
        curPriceLow = myString1;
        curPriceHigh = myString2;


    $('#bags').isotope('reloadItems').isotope();
    $('#bags').css('opacity','1');

});

// flatten object by concatting values
function concatValues( obj ) {
  var value = '';
  for ( var prop in obj ) {
    value += obj[ prop ];
  }
  return value;
}