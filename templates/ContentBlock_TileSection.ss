<section class="content-block">
    <% if TilesPerRow == One %>
        <% loop ContentTiles %>
            <div class="row">
                <div class="col-sm-12">
                    $RenderTile
                </div>
            </div>
        <% end_loop %>
    <% else_if TilesPerRow == Two %>
        <% loop ContentTiles %>
            <% if Modulus(2) == 1 || First %>
                <div class="row">
            <% end_if %>
                <div class="col-sm-6">
                    $RenderTile
                </div>
            <% if Modulus(2) == 0 || Last %>
                </div>
            <% end_if %>
        <% end_loop %>
    <% else %>
        <% loop ContentTiles %>
            <% if Modulus(3) == 1 || First %>
                <div class="row">
            <% end_if %>
                <div class="col-sm-4">
                    $RenderTile
                </div>
            <% if Modulus(3) == 0 || Last %>
                </div>
            <% end_if %>
        <% end_loop %>
    <% end_if %>
</section>
