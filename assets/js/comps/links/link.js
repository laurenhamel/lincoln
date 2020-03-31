// Load dependencies.
const _ = require('lodash');

// Export component.
module.exports = {

  props: {
    redirect: {
      type: Boolean,
      default: true
    },
    label: {
      type: String,
      required: true
    },
    image: {
      type: String,
      required: false
    },
    placeholder: {
      type: String,
      required: true
    },
    link: {
      type: String,
      required: true
    }
  },

  data() {

    return {
      event: 'preview'
    };

  },

  methods: {

    preview(event) {

      if(this.redirect) return;

      event.preventDefault();

      this.$bus.$emit('preview', {
        event: 'preview',
        visible: true,
        link: this.$props
      });

    }

  }

};
