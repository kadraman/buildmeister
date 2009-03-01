var LabelledInput = new Class({

     Implements: [Options, Events],

     options: {
          inputs: [ ]
     },

     initialize: function(options) {
          this.setOptions(options);

          var inputs = this.options.inputs;
          var self = this;

          inputs.each(function(e) {
               e.addEvent('focus', function() {
                    self.inputFocus(e.id);
               })
               .addEvent('blur', function() {
                    self.inputBlur(e.id);
               })
               .setProperty('value', e.id)
               .setStyle('color', '#ccc');
          });
     },

     inputFocus: function(x) {
          if ($(x).value == x) {
               $(x).value = '';
          }

          $(x).setStyle('color', '#000');
     },

     inputBlur: function(x) {
          if ($(x).value == '') {
               $(x).value = x;
               $(x).setStyle('color', '#ccc');
          }
          else if ($(x).value == x) {
               $(x).setStyle('color', '#ccc');
          }
          else {
               $(x).setStyle('color', '#000');
          }
     }
});
