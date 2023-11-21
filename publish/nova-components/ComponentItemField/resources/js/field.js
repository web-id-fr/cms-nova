import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-component-item-field', IndexField)
  app.component('detail-component-item-field', DetailField)
  app.component('form-component-item-field', FormField)
})
