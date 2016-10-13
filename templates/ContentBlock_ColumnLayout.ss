<section class="content-block">
    <div class="row $RowClasses">
        <% if IsLayout("Three Column") %>
            <div class="col-sm-4">
                <div
                class="$ColumnClasses"
                style="background-color: $ColumnColour(One)"
                data-mh="Row_{$ID}">
                    $ColumnOneContent
                </div>
            </div>
            <div class="col-sm-4">
                <div
                class="$ColumnClasses"
                style="background-color: $ColumnColour(Two)"
                data-mh="Row_{$ID}">
                    $ColumnTwoContent
                </div>
            </div>
            <div class="col-sm-4">
                <div
                class="$ColumnClasses"
                style="background-color: $ColumnColour(Three)"
                data-mh="Row_{$ID}">
                    $ColumnThreeContent
                </div>
            </div>
        <% else_if IsLayout("Two Column") %>
            <div class="col-sm-6">
                <div
                class="$ColumnClasses"
                style="background-color: $ColumnColour(One)"
                data-mh="Row_{$ID}">
                    $ColumnOneContent
                </div>
            </div>
            <div class="col-sm-6">
                <div
                class="$ColumnClasses"
                style="background-color: $ColumnColour(Two)"
                data-mh="Row_{$ID}">
                    $ColumnTwoContent
                </div>
            </div>
        <% else %>
            <div class="col-xs-12">
                <div
                class="$ColumnClasses"
                style="background-color: $ColumnColour(One)"
                data-mh="Row_{$ID}">
                    $ColumnOneContent
                </div>
            </div>
        <% end_if %>
    </div>
</section>
