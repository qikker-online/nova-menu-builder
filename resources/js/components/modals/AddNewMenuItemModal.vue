<template>
  <modal :show="showModal" :align="'flex justify-end'" class="add-new-menu-item-modal">
    <div slot="container">
      <div class="flex flex-wrap justify-between mb-6">
        <h2 class="text-90 font-normal text-xl">{{ __('Add Menu item') }}</h2>
        <toggle-button v-model="newItem.enabled" :color="switchColor" :width="70" :sync="true" :labels="toggleLabels"/>
      </div>

      <form autocomplete="off" @submit.prevent="$emit(update ? 'updateItem' : 'confirmItemCreate')">

        <div class="tabs flex flex-row overflow-x-auto ">
          <button
            class="py-4 px-8 border-b-2 focus:outline-none tab"
            :class="[activeLocaleTab == locale ? 'text-grey-black font-bold border-primary': 'text-grey font-semibold border-40']"
            v-for="(localeName, locale) in locales"
            :key="locale"
            @click.prevent="handleLocaleTabClick(locale, $event)"
          >{{ localeName }}
          </button>
        </div>

        <div
          class="tab-content"
          :ref="localeName"
          v-for="(localeName, locale) in locales"
          v-show="activeLocaleTab == locale"
          :label="localeName"
          :key="'related-tabs-fields' + locale"
        >

          <div class="flex border-b border-40">
            <div class="w-1/5 py-4">
              <label class="inline-block text-80 pt-2 leading-tight">{{ __('Name') }}</label>
            </div>
            <div class="py-4 w-4/5">
              <input
                v-model="newItem.name[locale]"
                :id="'name-' + locale"
                type="text"
                placeholder="name"
                class="w-full form-control form-input form-input-bordered"
              />
            </div>
          </div>

        </div>

        <div class="flex border-b border-40">
          <div class="w-1/5 py-4">
            <label class="inline-block text-80 pt-2 leading-tight">{{ __('Type') }}</label>
          </div>
          <div class="py-4 w-4/5">
            <select
              :value="linkType.class"
              @input="e => $emit('onLinkTypeUpdate', e.target.value)"
              class="w-full form-control form-select"
            >
              <option value="" selected="selected" disabled="disabled">{{ __('Choose an option') }}</option>

              <option :value="type.class" v-for="(type, i) of linkTypes" :key="i">{{ type.name }}</option>
            </select>
          </div>
        </div>
        <template v-if="linkType.type === 'static-url'">
          <div class="flex border-b border-40">
            <div class="w-1/5 py-4">
              <label class="inline-block text-80 pt-2 leading-tight">{{ __('URL') }}</label>
            </div>
            <div class="py-4 w-4/5">
              <input
                v-model="newItem.value"
                id="url"
                type="text"
                :placeholder="__('URL')"
                class="w-full form-control form-input form-input-bordered"
              />
            </div>
          </div>
        </template>

        <template v-if="linkType.type === 'select'">
          <div class="flex border-b border-40">
            <div class="w-1/5 py-4">
              <label class="inline-block text-80 pt-2 leading-tight">{{ __('Model') }}</label>
            </div>

            <div class="py-4 w-4/5">
              <select
                :value="newItem.value"
                @input="e => $emit('onLinkModelUpdate', e.target.value)"
                class="w-full form-control form-select"
              >
                <option value="" selected="selected" disabled="disabled">{{ __('Choose an option') }}</option>

                <option :value="key" v-for="(key, i) of Object.keys(linkType.options)" :key="i">
                  {{ linkType.options[key] }}
                </option>
              </select>
            </div>
          </div>
        </template>
        <div class="flex border-b border-40">
          <div class="w-1/5 py-4">
            <label class="inline-block text-80 pt-2 leading-tight">{{ __('Parameters') }}</label>
          </div>
          <div class="py-4 w-4/5">
            <codemirror v-model="newItem.parameters" :options="cmOptions" :placeholder="cmPlaceholder"></codemirror>
          </div>
        </div>
        <div class="flex border-b border-40" v-if="linkType.type && linkType.type !== 'text'">
          <div class="w-1/5 py-4">
            <label class="inline-block text-80 pt-2 leading-tight">{{ __('Open in') }}</label>
          </div>
          <div class="py-4 w-4/5">
            <select v-model="newItem.target" class="w-full form-control form-select">
              <option value="_self">{{ __('Same window') }}</option>
              <option value="_blank">{{ __('New window') }}</option>
            </select>
          </div>
        </div>
      </form>
    </div>
    <div slot="buttons">
      <div class="ml-auto">
        <button
          type="button"
          @click.prevent="$emit('closeModal')"
          class="btn text-80 font-normal h-9 px-3 mr-3 btn-link"
        >
          {{ __('Cancel') }}
        </button>

        <button v-if="update === false" @click.prevent="$emit('confirmItemCreate')" class="btn btn-default btn-primary">
          {{ __('Create menu item') }}
        </button>

        <button v-else @click.prevent="$emit('updateItem')" class="btn btn-default btn-primary">
          {{ __('Update menu item') }}
        </button>
      </div>
    </div>
  </modal>
</template>
<script>
  import Modal from './Modal';
  import {codemirror} from 'vue-codemirror';

  import 'codemirror/addon/display/placeholder.js';
  import 'codemirror/lib/codemirror.css';
  import 'codemirror/theme/dracula.css';
  import 'codemirror/mode/javascript/javascript';

  export default {
    props: ['newItem', 'showModal', 'update', 'linkType', 'linkTypes', 'locales'],
    components: {
      Modal,
      codemirror,
    },
    data: () => ({
      activeLocaleTab: null,
      toggleLabels: false,
      switchColor: {},
      cmOptions: {
        tabSize: 2,
        theme: 'dracula',
        lineNumbers: false,
        lineWrapping: true,
        foldGutter: true,
        line: true,
        mode: {
          name: 'javascript',
          json: true,
        },
      },
      cmPlaceholder: '{\n  "exampleValue": 5\n}',
    }),
    methods: {
      handleLocaleTabClick(locale, event) {
        this.activeLocaleTab = locale;
      },
    },
    watch: {
      locales: function (newVal, oldVal) {
        this.handleLocaleTabClick(Object.keys(this.locales)[0])
      }
    },
    mounted() {
      this.toggleLabels = {checked: this.__('Enabled'), unchecked: this.__('Disabled')};
      this.switchColor = {checked: '#21b978', unchecked: '#dae1e7', disabled: '#eef1f4'};
    },
  };
</script>

<style lang="scss">
  .add-new-menu-item-modal {
    .CodeMirror {
      height: 100px;
      border-radius: 0.5rem;
      padding: 5px;

      .CodeMirror-placeholder {
        color: rgba(#6272a4, 0.7);
      }
    }
  }
</style>
