package sit.int221.oasip.DTO;

import lombok.AllArgsConstructor;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;
import sit.int221.oasip.Entity.Categories;

import java.time.Instant;

@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
public class EventsDTO {
    private Integer id;
    private String bookingName;
    private String eventEmail;
    private String eventNotes;
    private Instant eventStartTime;
    private Integer eventDuration;

//    @JsonIgnore
    private Categories eventCategoryID;
}
