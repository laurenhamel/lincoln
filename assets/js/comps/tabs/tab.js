// Load dependencies.
const _ = require('lodash');

// Export component.
module.exports = {

  props: {
    icon: {
      type: String,
      required: false
    },
    label: {
      type: String,
      required: true
    },
    event: {
      type: String,
      required: true
    },
    payload: {
      type: Object,
      default: () => ({})
    }
  },

  computed: {

    data() {

      return _.merge(this.payload, {
        event: this.event,
        referrer: this.$props
      });

    }

  },

  methods: {
    emit() {

      const { event, data: payload } = this;

      this.$bus.$emit(event, payload);

    }
  }

};
