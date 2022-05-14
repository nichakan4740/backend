package sit.int221.oasip.DTO;

import com.fasterxml.jackson.annotation.JsonIgnore;
import lombok.AllArgsConstructor;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;
import sit.int221.oasip.Entity.Event;
import sit.int221.oasip.Entity.Eventcategory;

import javax.persistence.Column;
import javax.persistence.OneToMany;
import java.time.Instant;
import java.util.Set;

@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
public class CategoryDTO {

    private Integer id;
    private String eventCategoryName;
    private String eventCategoryDescription;
    private Integer eventDuration;

    @JsonIgnore
    private Set<Event> event;
}
