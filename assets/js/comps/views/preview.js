// Export component.
module.exports = {

  created() {

    this.$bus.$on('preview', this.preview);

  },

  data() {
    return {
      previewing: false,
      link: null
    };
  },

  methods: {

    preview({ visible, link }) {

      this.previewing = visible;
      this.link = link;

    },

    close() {

      this.$bus.$emit('preview', {
        event: 'preview',
        visible: false,
        link: null
      });

    }

  }

};
