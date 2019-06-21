$(document).ready(function () {
output();


$('[id="up"]').click(function(){
    var input = $(this).parent().prev();
    var minus = $(this).parent().prev().prev().children();
    var min = parseInt(minus.data('min'));
    var max = parseInt($(this).data('max'));
    
    if (input.val() == "") {
    input.val("0");
    } else {
    input.val(parseInt(input.val()) + 1);
    if (parseInt(input.val()) >= max) {
        input.val(max);
    }
    }
    
    plusminus(input);
    output();
});

$('[id="down"]').on('click', function(){
    
    var input = $(this).parent().next();
    var plus = $(this).parent().next().next().children();
    var max = parseInt(plus.data('min'));
    var min = parseInt($(this).data('min'));
    
    if (input.val() == "") {
    input.val("0");
    } else {
    input.val(parseInt(input.val()) - 1);
    if (parseInt(input.val()) <= min) {
        input.val(min);
    } 
    }
    
    plusminus(input);
    output();
});



    $('#import').click(function(){
    	$.ajax({
            url: 'fsimcalc.php?'  + $('input[name=fid]:checked').serialize(),
            type: 'GET',
            dataType: 'html',
            success: function (data) {
            
            
            
            var result = $.parseJSON(data);
            
            //console.log(result);
            
            for (i=3; i <=10; i++) {
            if (result[i][0] !== null) {
            	$('input[name=base'+i+'][value='+result[i][0]+']').prop("checked", true);
            } else {
            	$('input[name=base'+i+'][value=1]').prop("checked", true);
            }
            }
            
            for(i = 13, j = 1; i <= 17 && j <= 5; i++, j++) {
            	if (result[3][j] !== null) {
                $( 'input[data-num='+i+']' ).val(result[3][j]);
                } else {
                $( 'input[data-num='+i+']' ).val(0);
                }
                plusminus($('input[data-num='+i+']'));
            }
            
            for(i = 18, j = 1; i <= 22 && j <= 5; i++, j++) {
            if (result[4][j] !== null) {
                $( 'input[data-num='+i+']' ).val(result[4][j]);
                } else {
                $( 'input[data-num='+i+']' ).val(0);
                }
                plusminus($('input[data-num='+i+']'));
            }
            
            for(i = 23, j = 1; i <= 26 && j <= 4; i++, j++) {
            if (result[5][j] !== null) {
                $( 'input[data-num='+i+']' ).val(result[5][j]);
                } else {
                $( 'input[data-num='+i+']' ).val(0);
                }
                plusminus($('input[data-num='+i+']'));
            }
            
            for(i = 27, j = 1; i <= 29 && j <= 3; i++, j++) {
            if (result[6][j] !== null) {
                $( 'input[data-num='+i+']' ).val(result[6][j]);
                } else {
                $( 'input[data-num='+i+']' ).val(0);
                }
                plusminus($('input[data-num='+i+']'));
            }
            
            for(i = 31, j = 1; i <= 35 && j <= 5; i++, j++) {
            if (result[7][j] !== null) {
                $( 'input[data-num='+i+']' ).val(result[7][j]);
                } else {
                $( 'input[data-num='+i+']' ).val(0);
                }
                plusminus($('input[data-num='+i+']'));
            }
            
            for(i = 36, j = 1; i <= 39 && j <= 4; i++, j++) {
            if (result[8][j] !== null) {
                $( 'input[data-num='+i+']' ).val(result[8][j]);
                } else {
                $( 'input[data-num='+i+']' ).val(0);
                }
                plusminus($('input[data-num='+i+']'));
            }
                
                //aggression
                for(i = 40, j = 1; i <= 44 && j <= 5; i++, j++) {
                if (result[9][j] !== null) {
                $( 'input[data-num='+i+']' ).val(result[9][j]);
                } else {
                $( 'input[data-num='+i+']' ).val(0);
                }
                plusminus($('input[data-num='+i+']'));
            }
                
                //suppression
                for(i = 45, j = 1; i <= 48 && j <= 4; i++, j++) {
                if (result[10][j] !== null) {
                $( 'input[data-num='+i+']' ).val(result[10][j]);
                } else {
                $( 'input[data-num='+i+']' ).val(0);
                }
                plusminus($('input[data-num='+i+']'));
            }
            
            
        output();
        }
        });
    });

    $('#reset').click(function(){
    	
    	for(i = 13; i <= 48; i++) {
                $( 'input[data-num='+i+']' ).val(0);
                plusminus($('input[data-num='+i+']'));
            }
    
        output();
    });

    $('#validate').click(function(){
        output();
    });
    
    function output() {
    var upgnum = $('.upgval').get().map(function(el) { return el.dataset.num });
    var upgval = $('.upgval').get().map(function(el) { return el.value });
    var link = 'fsim.php?' + $('input[name=fid]:checked').serialize();
    
    for(i = 0; i < upgnum.length; i++) {
        link += '&' + upgnum[i] + '=' + upgval[i];
    }
    
    //console.log(link);
    

    $.ajax({
            url: link,
            type: 'GET',
            dataType: 'html',
            success: function (data) {
                var result = $.parseJSON(data);
                if (result[0] != null) {
                $('#TotRespect').html(new Intl.NumberFormat('en-US').format(result[0]));
                $('#coreTot').html(new Intl.NumberFormat('en-US').format(result[1]));
                $('#availTot').html(new Intl.NumberFormat('en-US').format(result[2]));
                $('#customRespect').prop("hidden", false);
                $('#leftoverR').prop("hidden", false);
                } else {
                $('#customRespect').prop("hidden", true);
                $('#leftoverR').prop("hidden", true);
                }
                 var total = [];
                 var tots =[];
                
                for (i=3; i <=10; i++) {
                if (result[i][0] != 0){
                //console.log($("input[name=base" + i + "]:checked").data('num'));
                $('#br' + i).html("Branch: " + $('input[name=base'+i+']:checked').data('num'));
                $('#br' + i).prop("hidden", true);
                } else {
                $('#br' + i).html("Branch: ");
                $('#br' + i).prop("hidden", true);
                }
                }
                
                //criminality
                var Total3 = (result[3][0] * $('input[name=base3]:checked').val());
                if (Total3 != 0){
                total.push({base: 3, tot: result[3][0]});tots.push(Total3);
                }
                $('[id="crimTot"]').html(new Intl.NumberFormat('en-US').format(Total3));
                
                for(i = 13, j = 1; i <= 17 && j <= 5; i++, j++) {
                $('#' + i +'R').html(new Intl.NumberFormat('en-US').format((result[3][j] * $('input[name=base3]:checked').val())));
                }
                
                //fortitude
                var Total4 = (result[4][0] * $('input[name=base4]:checked').val());
                if (Total4 != 0){total.push({base: 4, tot: result[4][0]});tots.push(Total4);}
                $('[id="fortTot"]').html(new Intl.NumberFormat('en-US').format(Total4));
                for(i = 18, j = 1; i <= 22 && j <= 5; i++, j++) {
                $('#' + i +'R').html(new Intl.NumberFormat('en-US').format((result[4][j] * $('input[name=base4]:checked').val())));
                }
                
                //voracity
                var Total5 = (result[5][0] * $('input[name=base5]:checked').val());
                if (Total5 != 0){total.push({base: 5, tot: result[5][0]});tots.push(Total5);}
                $('[id="vorTot"]').html(new Intl.NumberFormat('en-US').format(Total5));
                for(i = 23, j = 1; i <= 26 && j <= 4; i++, j++) {
                $('#' + i +'R').html(new Intl.NumberFormat('en-US').format((result[5][j] * $('input[name=base5]:checked').val())));
                }
                
                //toleration
                var Total6 = (result[6][0] * $('input[name=base6]:checked').val());
                if (Total6 != 0){total.push({base: 6, tot: result[6][0]});tots.push(Total6);}
                $('[id="tolTot"]').html(new Intl.NumberFormat('en-US').format(Total6));
                for(i = 27, j = 1; i <= 29 && j <= 3; i++, j++) {
                $('#' + i +'R').html(new Intl.NumberFormat('en-US').format((result[6][j] * $('input[name=base6]:checked').val())));
                }
                
                //excursion
                var Total7 = (result[7][0] * $('input[name=base7]:checked').val());
                if (Total7 != 0){total.push({base: 7, tot: result[7][0]});tots.push(Total7);}
                $('[id="excurTot"]').html(new Intl.NumberFormat('en-US').format(Total7));
                for(i = 31, j = 1; i <= 35 && j <= 5; i++, j++) {
                $('#' + i +'R').html(new Intl.NumberFormat('en-US').format((result[7][j] * $('input[name=base7]:checked').val())));
                }
                
                //steadfast
                var Total8 = (result[8][0] * $('input[name=base8]:checked').val());
                if (Total8 != 0){total.push({base: 8, tot: result[8][0]});tots.push(Total8);}
                $('[id="steadTot"]').html(new Intl.NumberFormat('en-US').format(Total8));
                for(i = 36, j = 1; i <= 39 && j <= 4; i++, j++) {
                $('#' + i +'R').html(new Intl.NumberFormat('en-US').format((result[8][j] * $('input[name=base8]:checked').val())));
                }
                
                //aggression
                var Total9 = (result[9][0] * $('input[name=base9]:checked').val());
                if (Total9 != 0){total.push({base: 9, tot: result[9][0]});tots.push(Total9);}
                $('[id="aggTot"]').html(new Intl.NumberFormat('en-US').format(Total9));
                for(i = 40, j = 1; i <= 44 && j <= 5; i++, j++) {
                $('#' + i +'R').html(new Intl.NumberFormat('en-US').format((result[9][j] * $('input[name=base9]:checked').val())));
                }
                
                //suppression
                var Total10 = (result[10][0] * $('input[name=base10]:checked').val());
                if (Total10 != 0){total.push({base: 10, tot: result[10][0]});tots.push(Total10);}
                $('[id="supTot"]').html(new Intl.NumberFormat('en-US').format(Total10));
                for(i = 45, j = 1; i <= 48 && j <= 4; i++, j++) {
                $('#' + i +'R').html(new Intl.NumberFormat('en-US').format((result[10][j] * $('input[name=base10]:checked').val())));
                }
                
               
                //console.log(JSON.stringify(total));
               
                var TotalSim = 0;
                for(i = 0; i <= (total.length - 1); i++) {
                TotalSim += tots[i];
                }
                $('#TotalSim').html(new Intl.NumberFormat('en-US').format(TotalSim));
                $('#leftover').html(new Intl.NumberFormat('en-US').format((result[2] - TotalSim)));
                
                

    
    		//console.log('before: ', total);
    		total.sort(compare);
                //console.log('after compare: ', total);
                total.reverse(); 
		//console.log('reversed: ', total);
		
		for (i=3; i <= 10; i++) {
		$("#base"+i+"r").html('N/A');
		$("#base"+i+"r").parent().prop("hidden", true);
		}
		
		for(i = 0; i <= (total.length - 1); i++) {
		//console.log(total[i].base);
		$("#base"+total[i].base+"r").parent().prop("hidden", false);
		$("#base"+total[i].base+"r").html(i+1);
		}
                
                
                //console.log(result);
            }
        });
    
    }
    
    function compare( a, b ) {
  if ( a.tot < b.tot ){
    return -1;
  }
  if ( a.tot > b.tot ){
    return 1;
  }
  return 0;
}
    
    	// update input texts on input
	$('input[type=text]').on('input',function(e) {
		var min = parseInt($(this).prev().children().data('min'));
		var max = parseInt($(this).next().children().data('max'));
		if ($(this).val() < min) {
			$(this).val(min);
		}
		if ($(this).val() > max) {
			$(this).val(max);
		}
		
		$(this).parent().prev().find('span').html($(this).val());
		output();
	});
	
    	
	
	$('input[type=text]').change( function() {
	  var minus = $(this).prev().children();
	  var plus = $(this).next().children();
	  var min = parseInt(minus.data('min'));
	  var max = parseInt(plus.data('max'));
	  
	  if ($(this).val() == "") {
		$(this).val(min);
	  }
	  
	  plusminus($(this));
	  
	  output();
	});
	
	//instead of output, maybe make a different function if things are too laggy
	$('input[type=radio]').change(function() {
		output();
	});
	
	function plusminus(input) {
	  var minus = input.prev().children();
	  var plus = input.next().children();
	  var min = parseInt(minus.data('min'));
	  var max = parseInt(plus.data('max'));
	  
	  if (input.val() == "") {
		input.val(min);
	  }
	  
	  if (parseInt(input.val()) <= min) {
        	minus.prop('disabled', true);
    	  } else {
    	  	minus.prop('disabled', false);
    	  }
    	  
    	  if (parseInt(input.val()) >= max) {
        	plus.prop('disabled', true);
    	  } else {
    	  	plus.prop('disabled', false);
    	  }
	  
	  input.parent().prev().find('span').html(input.val());
	}
	
});