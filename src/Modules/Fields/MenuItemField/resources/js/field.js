import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-menu-item-field', IndexField)
  app.component('detail-menu-item-field', DetailField)
  app.component('form-menu-item-field', FormField)
})
