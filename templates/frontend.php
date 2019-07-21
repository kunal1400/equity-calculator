<div class="container">      
  <div id="calculator" class="row">
    <div class="col-12">
      <h2>Calculator</h2>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 col-sm-12">
      <div class="field">
        <h4>Salary component</h4>
        <div class="explainer">Gross yearly salary in USD</div>
        <div style="position: relative;">
          <input id="salary" type="text" data-numbertype="dollar" data-decimals="0" style="padding-left: 22px; width: 190px;"><span style="position: absolute; left: 2px; top: 7px; ">$</span>
        </div>
      </div>
      <div class="field">
        <h4>Equity component</h4>
        <div class="explainer">Stock options granted, vested over 4 years</div>
        <div class="parameter">
          <input id="options" type="text" list="optionsSuggestions" data-numbertype="regular" data-decimals="0">
          <datalist id="optionsSuggestions">
            <option value="5,000"></option>
            <option value="10,000"></option>
            <option value="15,000"></option>
            <option value="20,000"></option>
            <option value="50,000"></option>
            <option value="100,000"></option>
          </datalist>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-sm-12">
      <div class="field">
        <h4>Expected company valuation</h4>
        <div class="explainer">The value at which the company will exit</div>
        <div style="display: flex;">
          <input id="valuation" type="range" data-type="log" data-min="10000000" data-max="50000000000" min="0" max="37" value="1" step="1" data-numbertype="bigdollar" data-decimals="0"><span id="valuation-display" class="range-display">$10m</span>
        </div>
      </div>
      <div class="field">
        <h4>Expected additional dilution</h4>
        <div class="explainer">Share owned by future investors</div>
        <div style="display: flex;">
          <input id="dilution" type="range" data-type="linear" data-min="0" data-max="60" min="0" max="60" value="20" data-numbertype="percent" data-decimals="0"><span id="dilution-display" class="range-display">20%</span>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 col-sm-12">
      <div class="field">
        <h4>Strike price</h4>
        <div class="explainer">Price at which you can purchase your options</div>
        <div style="position: relative;">
          <input id="strike-price" type="text" data-numbertype="regular" data-decimals="2" style="padding-left: 22px; width: 190px;"><span style="position: absolute; left: 2px; top: 7px; ">$</span>
        </div>
      </div>
      <div class="field">
        <h4>Final value of one share</h4>
        <div class="explainer">Expected valuation / final # of shares</div>
        <div id="parameter" class="metric"><span id="final-share-value" data-numbertype="dollar" data-decimals="2">$0</span></div>
      </div>
    </div>
    <div class="col-md-6 col-sm-12">
      <div class="field">
        <h4>Number of fully diluted shares</h4>
        <div class="explainer">Existing shares at the time of the offer</div>
        <div style="position: relative;">
          <input id="nb-of-shares" type="text" data-numbertype="regular" data-decimals="0">
        </div>
      </div>
      <div class="field">
        <h4>Spread of your options</h4>
        <div class="explainer">Final share value minus your strike price</div>
        <div id="parameter" class="metric"><span id="spread" data-numbertype="dollar" data-decimals="2">$0</span></div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 col-sm-12">
      <h4>Package value</h4><br>
      <div class="explainer">After 4 years</div>
      <table class="sum">
        <tbody><tr>
          <td>from salary</td>
          <td id="output-overall-salary" data-numbertype="dollar" data-decimals="0">$0</td>
        </tr>
        <tr>
          <td>from equity</td>
          <td id="output-overall-stock" data-numbertype="dollar" data-decimals="0">$0</td>
        </tr>
        <tr>
          <td>total</td>
          <td id="output-overall-both" data-numbertype="dollar" data-decimals="0">$0</td>
        </tr>
      </tbody></table>
    </div>
    <div class="col-md-6 col-sm-12">
      <h4>&nbsp;</h4><br>
      <div class="explainer">Yearly</div>
      <table class="sum">
        <tbody><tr>
          <td>from salary</td>
          <td id="output-yearly-salary" data-numbertype="dollar" data-decimals="0">$0</td>
        </tr>
        <tr>
          <td>from equity</td>
          <td id="output-yearly-stock" data-numbertype="dollar" data-decimals="0">$0</td>
        </tr>
        <tr>
          <td>total</td>
          <td id="output-yearly-both" data-numbertype="dollar" data-decimals="0">$0</td>
        </tr>
      </tbody></table>
    </div>
  </div>  
</div>
<script type="text/javascript">
  jQuery(document).ready(function() {
    init();
    updateModel();
    
    jQuery('input').on('input', updateModel);
    jQuery('input[type="text"]').on('input', function() {
      if (jQuery(this).attr('id') === 'strike-price'){
        if (!jQuery(this).val()) {
          return updateModel();
        } else return;
      };
      var start = this.selectionStart,
        end = this.selectionEnd,
        original_length = jQuery(this).val().length;
        var n = formatInt(jQuery(this).val());
        var pad = n.length === original_length ? 0 : 1;
        jQuery(this).val(n);
        return this.setSelectionRange(start + pad, end + pad);
    });
    jQuery('input[type="range"]').on('input', function () {
      var disp = jQuery(this).attr('id');
      jQuery('#'+disp+'-display').text( formatNumbers( logSlider(jQuery(this)), jQuery(this) ) );
    });
  })  
</script>
