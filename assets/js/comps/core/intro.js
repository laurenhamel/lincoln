// Export component.
module.exports = {

  methods: {

    about() {

      this.$bus.$emit('about', {
        event: 'about',
        visible: true
      });

    }

  }

};
