<template>
    <div class="dropzone" id="dropzonecomponent"></div>
</template>

<script>
    export default {
        data() {
            dropzone: null
        },
        props: ['accept', 'placeholder', 'maxfiles', 'arquivos'],
        beforeMount() {
            Dropzone.autoDiscover = false;
        },
        mounted() {
            const self = this;
            $(document).ready(() => {
                Dropzone.options.dropzonecomponent = {
                    autoDiscover: false,
                    maxFiles: this.maxfiles || 10,
                    dictDefaultMessage: this.placeholder || "Selecione ou solte os arquivos aqui",
                    createImageThumbnails: true,
                    thumbnailWidth: 140,
                    thumbnailHeight: 91,
                    acceptedFiles: this.accept || null,
                    url: constants.SITE_PATH + '/arquivos/upload',
                    headers: {
                        'X-CSRF-Token': constants.CSRF_TOKEN
                    },
                    paramName: "arquivo",
                    addRemoveLinks: true,
                    dictCancelUpload: 'Cancelar',
                    dictUploadCanceled: 'Cancelado',
                    dictRemoveFile: 'Remover',
                    dictInvalidFileType: 'O tipo de arquivo é inválido',
                    dictCancelUploadConfirmation: 'Confirmar',
                    dictResponseError: 'Erro ao fazer upload',
                    dictFileTooBig: 'O arquivo é muito grande',
                    dictMaxFilesExceeded: 'Não é possível enviar mais arquivos. O máximo de arquivos é {{maxFiles}}.',
                    init: function () {
                        this.on("success", self.uploadSuccess);
                        this.on("removedfile", self.removedFile);
                        this.on("error", self.uploadError);
                    }
                };
                this.dropzone = $("#dropzonecomponent").dropzone()[0].dropzone;

                // Exibe os arquivos no dropzone caso já existam
                this.arquivos.forEach((arquivo) => {
                    const mockFile = {name: arquivo.nome, size: arquivo.tamanho, uuid: arquivo.id};
                    this.dropzone.emit("addedfile", mockFile);
                    this.dropzone.emit("thumbnail", mockFile, arquivo.url);
                    this.dropzone.emit("complete", mockFile);
                    this.adicionarInput(arquivo.id, arquivo.id)
                });
                this.dropzone.options.maxFiles = this.dropzone.options.maxFiles - (this.arquivos.length - 1);
            })
        },
        methods: {
            /**
             * Quando o upload do arquivo é feito com sucesso.
             *
             * @param file
             * @param response
             */
            uploadSuccess(file, response) {
                this.adicionarInput(file.upload.uuid, response)
            },

            adicionarInput(uuid, response) {
                const $dropzone = $(this.$el);
                const $file = $('<input type="hidden" name="arquivos[' + uuid + ']" />').val(response);
                $dropzone.after($file);
            },


            /**
             * Quando o arquivo é removido da fila de upload.
             *
             * @param file
             */
            removedFile(file) {
                let id = 0;
                if (typeof file.upload !== 'undefined') {
                    id = file.upload.uuid;
                } else {
                    id = file.uuid;
                }

                const $file = $('input[name="arquivos[' + id + ']"]');
                if ($file.length) {
                    $file.remove();
                }
            },

            /**
             * Quando der erro ao fazer upload do arquivo.
             *
             * @param file
             * @param errorMessage
             */
            uploadError(file, errorMessage) {
                Notifica.erro(errorMessage);
            }
        }
    }
</script>
