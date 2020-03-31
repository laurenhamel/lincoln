// Load dependencies.
const objectFitImages = require('object-fit-images');
const Vue = require('vue').default;
const _ = require('lodash');

// Define component namespace.
const namespace = 'linkn';

// Configure Vue.
Vue.options.delimiters = ['${', '}'];
Vue.prototype.$bus = new Vue();

// Load components.
const Components = _.reduce(require('./comps/**/*.js', {mode: 'list'}), (result, component) => {

  // Get file name.
  const file = component.name.split('/').slice(-1)[0];

  // Create a friendly component name.
  const name = `${namespace}-${_.kebabCase(file)}`;

  // Register the component definition.
  component.component = Vue.component(name, _.merge(component.module, {
    template: `#${name}`,
  }));

  // Save the component definition.
  return _.set(result, _.upperFirst(_.camelCase(component.name)), component.component);

}, {});

// Initialize polyfills.
objectFitImages('img');

// Initialize Vue.
const app = new Vue({ el: '#app' });
