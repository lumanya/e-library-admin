<template>
	<table id="table" class="table table-condensed table-bordered table-striped " width="100%" data-page-length="10">
		<thead>
		<tr>
			<th v-for="(column, index) in parameters.columns" :key="index" v-html="column.title"></th>
		</tr>
		</thead>
		<tfoot v-if="footer">
		<tr>
			<th v-for="(column,index) in parameters.columns" :key="index" v-html="column.footer"></th>
		</tr>
		</tfoot>
	</table>
</template>

<script>
    require('datatables.net-bs4');
    require('datatables.net-buttons-bs4');
    require('../../../../public/assets/plugin/datatables.net-bs4/css/dataTables.bootstrap4.min.css');
    // require( 'datatables.net-buttons/js/buttons.html5.js' ); 
    // require( 'datatables.net-buttons/js/buttons.flash.js' );
    // require( 'datatables.net-buttons/js/buttons.print.js' );



    export default {
        data() {
            return {
                dataTable: {},
            }
        },
        computed: {
            parameters() {
                const vueInstance = this;
                return window.$.extend({
                    serverSide: true,
                    processing: true,
					buttons: [
						{
							extend: 'csv',
							text: '<i class="fa fa-file-excel-o"></i> CSV',
                            className: 'btn btn-secondary btn-sm'
                        },
                        {
							extend: 'copy',
							text: '<i class="fa fa-file-pdf-o"></i> Copy',
							className: 'btn btn-secondary btn-sm'
						},
						// {
						// 	extend: 'print',
						// 	text: '<i class="fa fa-file-pdf-o"></i> Print',
						// 	className: 'btn btn-secondary btn-sm'
						// },
					],
                    language: {
                        'paginate': {
                            'previous': "<i class='fas fa-chevron-left'></i>",
                            'next': "<i class='fas fa-chevron-right'></i>"
                        },
                        'info':'_START_ - _END_ of _TOTAL_'
                    },
                    dom: '<"top"<"row"<"col-md-12"<"float-left"f><"float-right d-inline-flex"i<"ml-10"p>>><"col-md-12 mt-10"<"float-left"B><" mt-3 float-right"l>>>>',
                    bInfo:this.bInfo,
                    bPaginate:this.bPaginate,
                    bLengthChange:this.bLengthChange,
                    footer:this.footer
                }, {
                    ajax: this.ajax,
                    columns: this.columns
                }, this.options);
            }
        },
        props: {
            footer: {default: false},
            columns: {type: Array},
            ajax: {default: ''},
            options: {},
            bInfo:{type:Boolean,default:true},
            bLengthChange:{type:Boolean,default:true},
            bFilter:{type:Boolean,default:true},
            bPaginate:{type:Boolean,default:true}
        },
        mounted() {
            var data = this.dataTable = window.$(this.$el).DataTable(this.parameters);
            // console.log(Math.abs($(this.$el).parentsUntil('.card').width()));
            // console.log(Math.abs($(this.$el).width()));
            if(Math.abs($(this.$el).parentsUntil('.card-body').width())!=0 && Math.abs($(this.$el).parentsUntil('.card-body').width()) < Math.abs($(this.$el).width())){
                $(this.$el).addClass('table-responsive');
            }
        },
        destroyed() {
            this.dataTable.destroy();
        }
    }
</script>
