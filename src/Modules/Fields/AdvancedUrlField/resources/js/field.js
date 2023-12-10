import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-advanced-url-field', IndexField)
  app.component('detail-advanced-url-field', DetailField)
  app.component('form-advanced-url-field', FormField)
})
