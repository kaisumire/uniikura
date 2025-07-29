$(document).ready(function() {
    $('#search-button').on('click', function(e) {
        e.preventDefault(); // フォーム送信防止

        const keyword = $('#keyword').val();

        $.ajax({
            url: '/products/search',
            type: 'GET',
            data: { keyword: keyword },
            success: function(response) {
                let html = '';
                response.products.forEach(product => {
                    html += `<tr>
                        <td>${product.id}</td>
                        <td><img src="/storage/${product.img_path || ''}" width="100"></td>
                        <td>${product.name}</td>
                        <td>${product.kakaku}</td>
                        <td>${product.zaiko}</td>
                        <td>${product.maker}</td>
                        <td><a href="/products/${product.id}">詳細</a></td>
                        <td>
                            <button class="delete-btn" data-id="${product.id}">削除</button>
                        </td>
                    </tr>`;
                });

                $('#product-list').html(html);
            },
            error: function() {
                alert('検索中にエラーが発生しました');
            }
        });
    });

    $(document).on('click', '.delete-btn', function() {
        if (!confirm('本当に削除しますか？')) return;

        const productId = $(this).data('id');
        const button = $(this);

        $.ajax({
            url: `/products/${productId}`,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    button.closest('tr').remove();
                } else {
                    alert('削除に失敗しました');
                }
            },
            error: function() {
                alert('削除リクエストに失敗しました');
            }
        });
    });
});

