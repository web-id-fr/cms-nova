import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-service-item-field', IndexField)
  app.component('detail-service-item-field', DetailField)
  app.component('form-service-item-field', FormField)
})
