package sit.int221.oasip.DTO;

import com.fasterxml.jackson.annotation.JsonIgnore;
import lombok.AllArgsConstructor;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;
import sit.int221.oasip.Entity.Eventcategory;

import javax.persistence.Column;
import java.time.Instant;
import java.time.LocalTime;

@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
public class EventDTO {
    private Integer id;
    private String bookingName;
    private String eventEmail;
    private String eventCategory;
    private Instant eventStartTime;
    private Integer eventDuration;
    private String eventNotes;

//    @JsonIgnore
    private Eventcategory eventCategoryID;
}
