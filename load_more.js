jQuery(document).ready(function($) {

    const ajaxLoadMore = () => {
            console.log('hello from load more');

            const loadMorebutton = $('a.lm-commons-text');

            if (typeof (loadMorebutton)!='undefined' && loadMorebutton != null) {

              
              $(loadMorebutton).click(function (e) {
                e.preventDefault();
                  let dataValue = $(this).data('value');
                  let current_group = $('div#tb-gallery-'+ dataValue);
                  let current_page = $(current_group).data('page');
                  let max_pages = $(current_group).data('max');
             

                  let params = new URLSearchParams();
                    params.append('action', 'load_more_posts');
                    params.append('current_page', current_page);
                    params.append('parent_group', dataValue);
                

                axios.post('/wp-admin/admin-ajax.php', params)
                  .then(res => {
                    console.log({res});

                    $(current_group).append(res.data.data);

                    current_page++;

                    $(current_group).attr('data-page', current_page);
                  })
                    .catch(function (error){
                      console.log(error);
                    });

              });
            }
        }

        ajaxLoadMore();

});
