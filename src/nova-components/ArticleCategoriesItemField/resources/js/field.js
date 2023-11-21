import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-article-categories-item-field', IndexField)
  app.component('detail-article-categories-item-field', DetailField)
  app.component('form-article-categories-item-field', FormField)
})
