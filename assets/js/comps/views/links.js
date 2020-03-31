// Export component.
module.exports = {

  data() {
    return {
      mode: null
    };
  },

  created() {

    this.$bus.$on('layout', ({ mode }) => this.mode = mode);

  }

};
