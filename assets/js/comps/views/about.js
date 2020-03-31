// Export component.
module.exports = {

  created() {

    this.$bus.$on('about', this.about);

  },

  data() {
    return {
      showing: false
    };
  },

  methods: {

    about({ visible }) {

      this.showing = visible;

    },

    close() {

      this.$bus.$emit('about', {
        event: 'about',
        visible: false
      });

    }

  }

};
