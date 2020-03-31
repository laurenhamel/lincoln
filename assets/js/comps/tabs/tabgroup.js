// Load dependencies.
const _ = require('lodash');

// Export component.
module.exports = {

  props: {
    tabs: {
      type: Array,
      required: true
    },
    event: {
      type: String,
      required: true
    }
  },

  data() {
    return {
      selected: 0,
      events: []
    };
  },

  computed: {

    active() {

      return this.tabs[this.selected];

    },

    data() {

      return _.merge(this.active.payload, {
        event: this.event,
        referrer: null
      });

    }

  },

  created() {

    const { event, tabs } = this;

    this.selected = _.findIndex(tabs, { default: true });
    this.events = _.uniq(_.map(tabs, (tab) => _.pick(tab, 'event').event));

    this.$nextTick(() => {

      this.$bus.$emit(event, this.data);
      this.$bus.$on(event, ({ referrer }) => {

        this.selected = _.findIndex(tabs, { label: referrer.label });

      });
      
    });

  }

};
