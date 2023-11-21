import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-translatable', IndexField)
  app.component('detail-translatable', DetailField)
  app.component('form-translatable', FormField)
})
