define(['jquery', 'Magento_Ui/js/modal/modal'], function ($, modal) {
    'use strict';
    
     $(document).on('click','#product-addtocart-button', function(){
          var engraving  = $('#engraving').val();
          var size  = $('#size').val();
          if(!(engraving == "" && size == "" || engraving != "" && size != ""))
          {
            alert('Both Input Field must have values.');
		            return false;
          }
      
    	});
});